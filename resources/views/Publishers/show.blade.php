<x-app-layout>
    <x-slot name="header">
        <h2 class="text-black text-3xl font-bold">
            Publisher Details
        </h2>
    </x-slot>

    <div class="py-12 px-1">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="card bg-gray-300 shadow-xl space-y-6 p-6">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                    <strong class="text-bold text-gray-900">Name:</strong>
                    <p class="text-gray-500">{{ $publisher->name }}</p>
                </div>

                <figure class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                    <strong class="text-bold text-gray-900">Logo:</strong>
                    <img src="{{ $publisher->logo }}" alt="{{ $publisher->name }} logo" class="rounded-lg shadow-md mx-auto">
                </figure>

                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">

                    <strong class="text-bold text-gray-900">Books from this publisher:</strong>
                    @if($books->isEmpty())
                        <p class="text-gray-500 mt-2">This publisher has no books yet.</p>
                    @else
                        <ul class="list-disc pl-5 mt-3 space-y-2">
                            @foreach($books as $book)
                                <li>
                                    <a href="{{ route('books.show', $book->id) }}"
                                       class="hover:underline">
                                        {{ $book->name }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>

                <div class="flex flex-col sm:flex-row gap-4 mb-6 text-center justify-between">
                    <x-button href="/publishers">Publishers List</x-button>

                    @auth
                        <x-button href="{{ route('dashboard') }}">Home</x-button>
                    @else
                        <x-button href="/">Home</x-button>
                    @endauth

                    @can('update')
                        <x-button href="/publishers/{{ $publisher->id }}/edit">Edit publisher</x-button>
                    @endcan
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
