<?php

namespace App\Http\Controllers;

use App\Actions\Fortify\PasswordValidationRules;
use App\Models\Author;
use App\Models\Book;
use App\Models\Publisher;
use App\Models\User;
use Illuminate\Http\Request;
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
            'recent_books' => Book::latest()->take(12)->get(),
        ]);
    }

    public function dashboard()
    {
        return view('dashboard', [
            'books_count' => Book::count(),
            'authors_count' => Author::count(),
            'publishers_count' => Publisher::count(),
            'recent_books' => Book::latest()->take(8)->get(),
        ]);
    }

    public function admin_panel()
    {
        return view('admin_panel');
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
        ]);

        $new_admin->assignRole('admin');
        $new_admin->sendEmailVerificationNotification();

        return redirect('/dashboard')->with('success', 'Admin has been created.');
    }
}
