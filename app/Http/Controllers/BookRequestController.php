<?php

namespace App\Http\Controllers;

use App\Jobs\SendBookAvailableEmail;
use App\Jobs\SendBookRequestEmail;
use App\Models\Book;
use App\Models\BookRequest;
use App\Models\CartItem;
use App\Models\Notification;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookRequestController extends Controller
{
    public function index(Request $request)
    {
        $userId = Auth::id();

        $activeRequests = BookRequest::where('user_id', $userId)
            ->where('is_returned', false)
            ->count();

        $last30DaysRequests = BookRequest::where('user_id', $userId)
            ->where('created_at', '>=', now()->subDays(30))
            ->count();

        $returnedToday = BookRequest::where('user_id', $userId)
            ->whereDate('return_date', now()->toDateString())
            ->count();

        $query = BookRequest::where('user_id', $userId);

        if ($request->has('status')) {
            if ($request->status == 'returned') {
                $query->where('is_returned', true)->where('is_confirmed', true);
            } elseif ($request->status == 'pending_return_confirm') {
                $query->where('is_confirmed', false)->where('is_returned', true);
            } elseif ($request->status == 'active') {
                $query->where('is_returned', false);
            }
        }

        $bookRequests = $query->with('book.authors')->latest()->paginate(10);

        return view('book_requests.index', compact('bookRequests', 'activeRequests', 'last30DaysRequests', 'returnedToday'));
    }

    public function indexAdmin(Request $request)
    {
        $activeRequests = BookRequest::where('is_returned', false)->count();

        $last30DaysRequests = BookRequest::where('created_at', '>=', now()->subDays(30))->count();

        $returnedToday = BookRequest::where('return_date', now()->toDateString())->count();

        $query = BookRequest::query();

        if ($request->has('status')) {
            if ($request->status == 'returned') {
                $query->where('is_returned', true)->where('is_confirmed', true);
            } elseif ($request->status == 'pending_return_confirm') {
                $query->where('is_confirmed', false)->where('is_returned', true);
            } elseif ($request->status == 'active') {
                $query->where('is_returned', false);
            }
        }

        $bookRequests = $query->with('book.authors')->paginate(10);

        return view('book_requests.index_admin', compact('bookRequests', 'activeRequests', 'last30DaysRequests', 'returnedToday','bookRequests'));
    }

    public function userBookRequestsForAdmin(User $user)
    {
        $userBookRequests = User::find($user->id)->bookRequests()->paginate(20);

        return view('book_requests.user-book-requests-for-admin', compact('userBookRequests', 'user'));
    }

    public function bookRequestsHistory(Book $book)
    {
        $bookRequests = $book->bookRequests()->paginate(20);
        return view('book_requests.book_requests_history', compact('book', 'bookRequests'));
    }

    public function available(Request $request)
    {
        $query = $request->input('query');

        $books = Book::whereDoesntHave('bookRequests', function ($q) {
            $q->whereIn('status', ['active', 'pending_return_confirm']);
        })
            ->whereDoesntHave('orderItems.order', function ($q) {
                $q->whereIn('status', ['pending', 'completed']);
            })
            ->when($query, function ($q) use ($query) {
                $q->where('name', 'like', '%' . $query . '%');
            })
            ->with('authors', 'publisher')
            ->latest()
            ->paginate(10);

        $citizens = User::role('citizen')
            ->withCount(['bookRequests' => function ($query) {
                $query->whereIn('status', ['active', 'pending_return_confirm']);
            }])
            ->having('book_requests_count', '<', 3)
            ->get();

        return view('book_requests.available', compact('books', 'citizens', 'query'));
    }


    public function requestBook(Request $request, Book $book)
    {
        $user = Auth::user()->hasRole('admin') && $request->has('user_id')
            ? User::findOrFail($request->user_id)
            : Auth::user();

        if (BookRequest::where('book_id', $book->id)->whereIn('status', ['active', 'pending_return_confirm'])->exists()) {
            return back()->with('error', 'This book has already been requested.');
        }

        if ($user->bookRequests()->whereIn('status', ['active', 'pending_return_confirm'])->count() >= 3) {
            return back()->with('error', 'This user cannot request more than 3 books.');
        }

        $bookRequest = BookRequest::create([
            'user_id'      => $user->id,
            'book_id'      => $book->id,
            'user_name'    => $user->name,
            'user_email'   => $user->email,
            'request_date' => now(),
            'due_date'     => now()->addDays(5),
            'status'       => 'active',
        ]);

        SendBookRequestEmail::dispatch($bookRequest, $user, true);

        $admins = User::whereHas('roles', function ($query) {
            $query->where('name', 'admin');
        })->get();

        foreach ($admins as $admin) {
            SendBookRequestEmail::dispatch($bookRequest, $admin, false);
        }

        $affectedUsers = CartItem::where('book_id', $book->id)
            ->where('user_id', '!=', Auth::id())
            ->pluck('user_id')
            ->unique();

        foreach ($affectedUsers as $userId) {
            Notification::create([
                'user_id' => $userId,
                'message' => 'Some books in your cart are no longer available and were removed. Sorry for the inconvenience.',
            ]);
        }

        CartItem::where('book_id', $book->id)->delete();

        return redirect()->route('book_requests.available')->with('success', 'Request has been sent.');
    }


    public function returnBook(BookRequest $bookRequest)
    {
        $bookRequest->update([
            'is_returned' => true,
            'return_date' => now(),
            'status' => 'pending_return_confirm',
        ]);

        return back()->with('success', 'Request has been returned.');
    }

    public function confirmReturn(BookRequest $bookRequest)
    {
        $totalDays = Carbon::parse($bookRequest->request_date)->diffInDays(now(), false);

        $bookRequest->update([
            'is_confirmed' => true,
            'confirmed_at' => now(),
            'status' => 'returned',
            'total_request_days' => $totalDays,
        ]);

        SendBookAvailableEmail::dispatch($bookRequest->book);

        return back()->with('success', 'Book has been returned.');
    }
}
