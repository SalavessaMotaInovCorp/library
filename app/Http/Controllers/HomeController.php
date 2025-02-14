<?php

namespace App\Http\Controllers;

use App\Actions\Fortify\PasswordValidationRules;
use App\Models\Author;
use App\Models\Book;
use App\Models\BookRequest;
use App\Models\Publisher;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;

class HomeController extends Controller
{
    use PasswordValidationRules;

    public function index()
    {
        return view('welcome', [
            'books_count' => Book::count(),
            'authors_count' => Author::count(),
            'publishers_count' => Publisher::count(),
            'recent_books' => Book::latest()->take(4)->get(),
        ]);
    }

    public function dashboard()
    {
        $readerOfTheMonth = User::withCount(['bookRequests' => function ($query) {
            $query->whereMonth('created_at', Carbon::now()->month);
        }])
            ->orderByDesc('book_requests_count')
            ->first();

        return view('dashboard', [
            'books_count' => Book::count(),
            'authors_count' => Author::count(),
            'publishers_count' => Publisher::count(),
            'recent_books' => Book::latest()->take(4)->get(),
            'readerOfTheMonth' => $readerOfTheMonth,
        ]);
    }

    public function admin_panel()
    {
        $totalUsers = User::count();
        $totalBooks = Book::count();
        $totalAuthors = Author::count();
        $totalPublishers = Publisher::count();

        $totalBookRequests = BookRequest::count();
        $totalReturnedRequests = BookRequest::where('status', 'returned')->count();
        $totalPendingReturnRequests = BookRequest::where('status', 'pending_return_confirm')->count();
        $totalActiveRequests = BookRequest::where('status', 'active')->count();
        $totalPastDueRequests = BookRequest::where('due_date', '<', date('Y-m-d'))->count();

        return view('admin_panel', compact(
            'totalUsers',
            'totalBooks',
            'totalAuthors',
            'totalPublishers',
            'totalBookRequests',
            'totalReturnedRequests',
            'totalPendingReturnRequests',
            'totalActiveRequests',
            'totalPastDueRequests',
        ));
    }

    public function create_admin()
    {
        return view('create_admin');
    }

    public function store_admin()
    {
        request()->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => $this->passwordRules(),
        ]);

        $new_admin = User::create([
            'name' => request('name'),
            'email' => request('email'),
            'password' => Hash::make(request('password')),
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);

        $new_admin->assignRole('admin');

        return redirect('/dashboard')->with('success', 'Admin has been created.');
    }
}
