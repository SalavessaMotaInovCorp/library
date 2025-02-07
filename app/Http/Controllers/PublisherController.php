<?php

namespace App\Http\Controllers;

use App\Models\Publisher;
use Illuminate\Http\Request;

class PublisherController extends Controller
{
    // Display a list of publishers
    public function index(Request $request)
    {
        return view('publishers.index');
    }

    // Show details of a specific publisher
    public function show(Publisher $publisher)
    {
        $books = $publisher->books;

        return view('publishers.show', compact('publisher', 'books'));
    }

    // Show form to create a new publisher
    public function create()
    {
        return view('publishers.create');
    }

    // Store a new publisher in the database
    public function store()
    {
        request()->validate([
            'name' => 'required',
            'logo' => ['required', 'min:5']
        ]);

        Publisher::create([
            'name' => request('name'),
            'logo' => request('logo')
        ]);

        return redirect('/publishers');
    }

    // Show form to edit an existing publisher
    public function edit(Publisher $publisher)
    {
        return view('publishers.edit', compact('publisher'));
    }

    // Update publisher information
    public function update(Publisher $publisher)
    {
        request()->validate([
            'name' => 'required',
            'logo' => ['required', 'min:5']
        ]);

        $publisher->update([
            'name' => request('name'),
            'logo' => request('logo')
        ]);

        return redirect('/publishers');
    }

    // Delete a publisher from the database
    public function destroy(Publisher $publisher)
    {
        $publisher->delete();

        return redirect('/publishers');
    }
}
