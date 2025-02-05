<?php

namespace App\Http\Controllers;

use App\Models\Publisher;
use Illuminate\Http\Request;

class PublisherController extends Controller
{
    public function index(Request $request)
    {
        $query = Publisher::query();

        if($request->has('name')){
            $query->where('name', 'like', '%'.$request->get('name').'%');
        }

        $publishers = $query->paginate(10);

        return view('publishers.index', compact('publishers'));
    }

    public function show(Publisher $publisher)
    {
        return view('publishers.show', compact('publisher'));
    }

    public function create()
    {
        return view('publishers.create');
    }

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

    public function edit(Publisher $publisher)
    {
        return view('publishers.edit', compact('publisher'));
    }

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

    public function destroy(Publisher $publisher)
    {
        $publisher->delete();

        return redirect('/publishers');
    }
}
