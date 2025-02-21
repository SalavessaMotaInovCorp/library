<?php

namespace App\Http\Controllers;

use App\Jobs\SendNewBookReviewEmailToAdmins;
use App\Mail\BookReviewStatusMail;
use App\Models\Book;
use App\Models\BookReview;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class BookReviewController extends Controller
{
    public function create(Request $request, Book $book)
    {
        return view('book_reviews.create', compact('book'));
    }

    public function store(Request $request, Book $book)
    {
        $request->validate([
            'rating' => 'required|integer|between:1,5',
            'comment' => 'required|string|max:255'
        ]);

        $bookReview = BookReview::create([
            'book_id' => $book->id,
            'user_id' => auth()->user()->id,
            'rating' => $request->rating,
            'comment' => $request->comment,
            'status' => 'pending'
        ]);

        $user = Auth::user();

        SendNewBookReviewEmailToAdmins::dispatch($bookReview);

        return redirect()->route('book_requests.index');
    }


    public function edit(BookReview $bookReview)
    {
        return view('book_reviews.edit', compact('bookReview'));
    }

    public function update(Request $request, BookReview $bookReview)
    {
        if(Auth::user()->hasRole('admin')) {
            $validated = $request->validate([
                'rating' => 'required|integer|between:1,5',
                'comment' => 'required|string|max:255',
                'status' => 'required|string',
                'justification' => 'nullable|string|max:255'
            ]);

            $bookReview->update($validated);

            Mail::to($bookReview->user->email)->send(new BookReviewStatusMail($bookReview));
        }
        else {
            $request->validate([
                'rating' => 'required|integer|between:1,5',
                'comment' => 'required|string|max:255',
                'justification' => 'nullable|string|max:255'
            ]);

            $bookReview->update([
                'rating' => $request->rating,
                'comment' => $request->comment,
                'status' => "pending",
                'justification' => $request->justification
            ]);
        }

        return back()->with('success', 'Review updated successfully.');
    }

}
