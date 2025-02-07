<?php

namespace App\Http\Controllers;

use App\Models\Author;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    // Display a list of authors
    public function index(Request $request)
    {
        return view('authors.index');
    }

    // Show details of a specific author
    public function show(Author $author)
    {
        $books = $author->books()->orderBy('name')->paginate(10);

        return view('authors.show', compact('author', 'books'));
    }

    // Show form to create a new author
    public function create()
    {
        return view('authors.create');
    }

    // Store a new author in the database
    public function store()
    {
        request()->validate([
            'name' => 'required',
            'photo' => ['required', 'min:5']
        ]);

        Author::create([
            'name' => request('name'),
            'photo' => request('photo')
        ]);

        return redirect('/authors');
    }

    // Show form to edit an existing author
    public function edit(Author $author)
    {
        return view('authors.edit', ['author' => $author]);
    }

    // Update author information
    public function update(Author $author)
    {
        request()->validate([
            'name' => 'required',
            'photo' => ['required', 'min:5']
        ]);

        $author->update([
            'name' => request('name'),
            'photo' => request('photo')
        ]);

        return redirect('/authors');
    }

    // Delete an author
    public function destroy(Author $author)
    {
        $author->delete();

        return redirect('/authors');
    }
}
