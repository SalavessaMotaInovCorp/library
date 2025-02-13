<x-app-layout>
    <x-slot name="header">
        <h2 class="text-black text-3xl font-bold">
            Book Details
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="card bg-gray-300 shadow-xl space-y-6 p-6">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                    <strong class="text-bold text-gray-900">Title:</strong>
                    <p class="text-gray-500">{{ $book->name }}</p>
                </div>

                <figure class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                    <strong class="text-bold text-gray-900">Cover:</strong>
                    <img src="{{ $book->cover_image }}" alt="Book Cover" class="rounded-lg shadow-md mx-auto">
                </figure>

                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                    <strong class="text-bold text-gray-900">ISBN:</strong>
                    <p class="text-gray-500">{{ $book->isbn }}</p>
                </div>

                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                    <strong class="text-bold text-gray-900">Author(s):</strong>
                    @foreach($authors as $author)
                        <a href="/authors/{{ $author->id }}">
                            <p class="text-gray-500 hover:underline">{{ $author->name }}</p>
                        </a>
                    @endforeach
                </div>

                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                    <strong class="text-bold text-gray-900">Publisher:</strong>
                    <a href="/publishers/{{ $book->publisher->id }}">
                        <p class="text-gray-500 hover:underline">{{ $book->publisher->name }}</p>
                    </a>
                </div>

                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                    <strong class="text-bold text-gray-900">Description:</strong>
                    <article class="text-gray-500">{{ $book->description }}</article>
                </div>

                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                    <strong class="text-bold text-gray-900">Price:</strong>
                    <p class="text-gray-500">{{ number_format($book->price, 2) }} €</p>
                </div>

                @auth
                    @if(Auth::user()->hasRole('admin'))
                        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6 text-center cursor-pointer">
                            <a href="/book-requests/{{ $book->id }}/history" class="hover:underline">
                                <strong class="text-gray-900 cursor-pointer">See Requests History</strong>
                            </a>
                        </div>
                    @else
                        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6 text-center">
                            @if ($hasActiveRequest)
                                <p class="text-gray-900 font-semibold">You already have an active request for this book.</p>
                            @elseif ($isBookRequestedByOthers)
                                <p class="text-gray-900 font-semibold">This book is currently requested by another user.</p>
                            @else
                                @php
                                    $activeRequests = Auth::user()->bookRequests()
                                        ->whereIn('status', ['active', 'pending_return_confirm'])
                                        ->count();
                                @endphp

                                @if ($activeRequests < 3)
                                    <label for="confirm-request-{{ $book->id }}" class="btn text-white px-4 py-2 rounded cursor-pointer">
                                        Request this book
                                    </label>
                                    <input type="checkbox" id="confirm-request-{{ $book->id }}" class="modal-toggle"/>

                                    <div class="modal">
                                        <div class="modal-box text-white">
                                            <h3 class="font-bold text-lg">Confirm Book Request</h3>
                                            <p class="py-4">Are you sure you want to request the book:
                                                <strong>{{ $book->name }}</strong>?</p>
                                            <div class="modal-action flex justify-between">
                                                <label for="confirm-request-{{ $book->id }}" class="btn bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Cancel</label>
                                                <form method="POST" action="{{ route('book_requests.request', $book->id) }}">
                                                    @csrf
                                                    <x-button type="submit">Confirm</x-button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <p class="text-red-500 font-semibold">No more requests available.</p>
                                @endif
                            @endif
                        </div>
                    @endif
                @endauth

                <div class="flex justify-between mt-6">
                    <x-button href="/books">Books List</x-button>

                    @auth
                        <x-button href="{{ route('dashboard') }}">Home</x-button>
                    @else
                        <x-button href="/">Home</x-button>
                    @endauth

                    @can('update')
                        <x-button href="/books/{{ $book->id }}/edit">Edit book</x-button>
                    @endcan
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
