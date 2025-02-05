<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
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
                    <p class="text-gray-500">${{ number_format($book->price, 2) }}</p>
                </div>

                <div class="flex justify-between">
                    <p class="mt-6">
                        <x-button href="{{ url()->previous() }}">Back</x-button>
                    </p>

                    <p class="mt-6">
                        <x-button href="/dashboard">Home</x-button>
                    </p>

                    <p class="mt-6">
                        <x-button href="/books/{{ $book->id }}/edit">Edit book</x-button>
                    </p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
