<x-app-layout>
    <x-slot name="header">
        <div class="bg-cover bg-center">
            <div class="inset-0 flex items-center justify-center">
                <h1 class="text-black text-5xl font-bold">Inovcorp Library</h1>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-10">

            <div class="grid gap-10 md:grid-cols-3 text-center mb-6">
                <div class="bg-gray-50 p-6 rounded-lg text-black shadow-lg">
                    <h3 class="text-4xl font-bold">{{ $books_count }}</h3>
                    <p class="text-lg">Books Available</p>
                </div>
                <div class="bg-gray-50 p-6 rounded-lg text-black shadow-lg">
                    <h3 class="text-4xl font-bold">{{ $authors_count }}</h3>
                    <p class="text-lg">Authors</p>
                </div>
                <div class="bg-gray-50 p-6 rounded-lg text-black shadow-lg">
                    <h3 class="text-4xl font-bold">{{ $publishers_count }}</h3>
                    <p class="text-lg">Publishers</p>
                </div>
            </div>

            <form action="/search" class="relative flex items-center justify-center mb-6">
                @csrf
                <input type="text" class="input input-bordered w-full max-w-md" name="query" placeholder="Book Quick Search">
                 <x-button class="btn btn-primary ml-2">🔍 Search</x-button>
            </form>


            <h2 class="text-2xl font-bold text-gray-800 mb-3">Recent Books</h2>
            <div class="grid gap-6 md:grid-cols-3 lg:grid-cols-4 mb-6">
                @foreach($recent_books as $book)
                    <div class="card bg-white shadow-xl">
                        <figure>
                            <img src="{{ $book->cover_image }}" alt="Book Cover" class="h-48 w-full object-cover">
                        </figure>
                        <div class="p-4">
                            <h3 class="text-lg font-bold">{{ $book->name }}</h3>
                            <p class="text-sm text-gray-600">{{ Str::limit($book->description, 50) }}</p>
                            <x-button href="/books/{{ $book->id }}" class="btn btn-primary btn-sm mt-4">View Details</x-button>
                        </div>
                    </div>
                @endforeach
            </div>

            <h2 class="text-2xl font-bold text-gray-800">Explore</h2>
            <div class="grid gap-6 md:grid-cols-3">
                <x-button href="/books" class="btn btn-outline btn-lg w-full">Browse Books</x-button>
                <x-button href="/authors" class="btn btn-outline btn-lg w-full">Meet the Authors</x-button>
                <x-button href="/publishers" class="btn btn-outline btn-lg w-full">Publishers</x-button>
            </div>

        </div>
    </div>
</x-app-layout>
