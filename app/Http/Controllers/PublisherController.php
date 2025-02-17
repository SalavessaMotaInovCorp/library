<?php

namespace App\Http\Controllers;

use App\Models\Publisher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
    public function store(Request $request)
    {
        request()->validate([
            'name' => 'required',
            'logo' => 'required|image|mimes:jpg,png,jpeg,gif,webp|max:2048'
        ]);

        if ($request->hasFile('logo')) {
            $imagePath = $request->file('logo')->store('publishers', 'public');
        } else {
            $imagePath = 'publishers/default_publisher_logo.png';
        }

        Publisher::create([
            'name' => request('name'),
            'logo' => $imagePath
        ]);

        return redirect('/publishers');
    }

    // Show form to edit an existing publisher
    public function edit(Publisher $publisher)
    {
        return view('publishers.edit', compact('publisher'));
    }

    // Update publisher information
    public function update(Request $request, Publisher $publisher)
    {
        $validated = $request->validate([
            'name' => 'required',
            'logo' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:12288']
        ]);

        if ($request->hasFile('logo')) {
            if ($publisher->logo) {
                Storage::delete('public/authors/' . $publisher->logo);
            }

            $imagePath = $request->file('logo')->store('publishers', 'public');
            $validated['logo'] = $imagePath;
        }

        $publisher->update($validated);

        return redirect('/publishers');
    }

    // Delete a publisher from the database
    public function destroy(Publisher $publisher)
    {
        $publisher->delete();

        return redirect('/publishers');
    }
}
