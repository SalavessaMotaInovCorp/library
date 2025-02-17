<?php

namespace App\Http\Controllers;

use App\Models\Author;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
    public function store(Request $request)
    {
        request()->validate([
            'name' => 'required',
            'photo' => 'required|image|mimes:jpg,png,jpeg,gif,webp|max:2048'
        ]);

        if ($request->hasFile('photo')) {
            $imagePath = $request->file('photo')->store('authors', 'public');
        } else {
            $imagePath = 'authors/default_author_photo.png';
        }

        Author::create([
            'name' => $request->name,
            'photo' => $imagePath
        ]);

        return redirect('/authors');
    }

    // Show form to edit an existing author
    public function edit(Author $author)
    {
        return view('authors.edit', ['author' => $author]);
    }

    // Update author information
    public function update(Request $request, Author $author)
    {
        $validated = $request->validate([
            'name' => 'required',
            'photo' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:12288']
        ]);

        if ($request->hasFile('photo')) {
            if ($author->photo) {
                Storage::delete('public/authors/' . $author->photo);
            }

            $imagePath = $request->file('photo')->store('authors', 'public');
            $validated['photo'] = $imagePath;
        }

        $author->update($validated);

        return redirect('/authors');
    }

    // Delete an author
    public function destroy(Author $author)
    {
        $author->delete();

        return redirect('/authors');
    }
}
