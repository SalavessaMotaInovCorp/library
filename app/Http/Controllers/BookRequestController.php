<?php

namespace App\Http\Controllers;

use App\Jobs\SendBookRequestEmail;
use App\Jobs\SendDueDateReminder;
use App\Models\Book;
use App\Models\BookRequest;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schedule;

class BookRequestController extends Controller
{
    public function index()
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

        $bookRequests = BookRequest::with('book.authors', 'book.publisher')
            ->where('user_id', $userId)
            ->paginate(20);

        return view('book_requests.index', compact('bookRequests', 'activeRequests', 'last30DaysRequests', 'returnedToday'));
    }

    public function indexAdmin()
    {
        $activeRequests = BookRequest::where('is_returned', false)->count();

        $last30DaysRequests = BookRequest::where('created_at', '>=', now()->subDays(30))->count();

        $returnedToday = BookRequest::where('return_date', now()->toDateString())->count();

        $bookRequests = BookRequest::with('user','book.authors', 'book.publisher')->paginate(20);

        return view('book_requests.index_admin', compact('bookRequests', 'activeRequests', 'last30DaysRequests', 'returnedToday'));
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

    public function available()
    {
        $books = Book::whereDoesntHave('bookRequests', function ($query) {
            $query->whereIn('status', ['active', 'pending_return_confirm']);
        })->with('authors', 'publisher')->paginate(10);

        $citizens = User::role('citizen')
            ->withCount(['bookRequests' => function ($query) {
                $query->whereIn('status', ['active', 'pending_return_confirm']);
            }])
            ->having('book_requests_count', '<', 3)
            ->get();

        return view('book_requests.available', compact('books', 'citizens'));
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

//        SendBookRequestEmail::dispatch($bookRequest, $user, true);
//
//        $admins = User::whereHas('roles', function ($query) {
//            $query->where('name', 'admin');
//        })->get();
//        foreach ($admins as $admin) {
//            SendBookRequestEmail::dispatch($bookRequest, $admin, false);
//        }

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

        return back()->with('success', 'Book has been returned.');
    }
}
