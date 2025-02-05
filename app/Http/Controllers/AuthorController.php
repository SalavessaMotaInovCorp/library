<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\Book;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    public function index(Request $request)
    {
        $query = Author::query();

        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }

        $authors = $query->paginate(10);

        return view('authors.index', [
            'authors' => $authors
        ]);
    }

    public function show(Author $author)
    {
        $books = $author->books()->orderBy('name')->paginate(10);

        return view('authors.show', compact('author', 'books'));
    }

    public function create()
    {
        return view('authors.create');
    }

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

    public function edit(Author $author)
    {
        return view('authors.edit', ['author' => $author]);
    }

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

    public function destroy(Author $author)
    {
        $author->delete();

        return redirect('/authors');
    }


}
