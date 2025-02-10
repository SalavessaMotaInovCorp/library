<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Inovcorp Library</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet"/>

        <!-- Styles / Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

    </head>
    <body class="font-sans antialiased bg-gray-100 text-gray-900">

        <div class="relative min-h-screen flex flex-col items-center justify-center">

            <div class="relative w-full max-w-7xl px-6">

                <header class="text-center">
                    <img src="https://aircinelmvc.blob.core.windows.net/resources/inovcorp_logo_book_bg_removed.png.png" alt="library" class="mx-auto w-16">
                    <strong class="text-5xl font-extrabold text-gray-900">Welcome to Inovcorp Library</strong><br/>
                    <p class="mt-4 text-lg text-gray-700">Register or Log In to explore thousands of books, meet renowned authors, and dive into a
                        world of knowledge.</p>
                    <div class="mt-6">
                        <x-button href="{{ route('register') }}" class="btn btn-primary btn-lg">Register</x-button>
                        <x-button href="{{ route('login') }}" class="btn btn-primary btn-lg ml-4">Log in</x-button>
                    </div>
                </header>

                <h2 class="text-2xl font-bold text-gray-800 mb-3">Explore</h2>
                <div class="grid gap-10 md:grid-cols-3 text-center mt-12">
                    <x-button href="/books" class="p-6 min-h-32 flex flex-col items-center justify-center rounded-lg shadow-lg">
                        <h3 class="text-4xl font-bold">{{ $books_count }}</h3>
                        <p class="text-lg">Books Available</p>
                    </x-button>

                    <x-button href="/books" class="p-6 min-h-32 flex flex-col items-center justify-center rounded-lg shadow-lg">
                        <h3 class="text-4xl font-bold">{{ $authors_count }}</h3>
                        <p class="text-lg">Authors</p>
                    </x-button>

                    <x-button href="/books" class="p-6 min-h-32 flex flex-col items-center justify-center rounded-lg shadow-lg">
                        <h3 class="text-4xl font-bold">{{ $publishers_count }}</h3>
                        <p class="text-lg">Publishers</p>
                    </x-button>
                </div>

                <h2 class="text-2xl font-bold text-gray-800 mt-12">Discover New Books</h2>
                <div class="grid gap-6 md:grid-cols-3 lg:grid-cols-4 mb-6">
                    @foreach($recent_books as $book)
                        <div class="card bg-white shadow-xl">
                            <figure>
                                <img src="{{ $book->cover_image }}" alt="Book Cover" class="h-48 w-full object-cover">
                            </figure>
                            <div class="p-4">
                                <h3 class="text-lg font-bold">{{ $book->name }}</h3>
                                <p class="text-sm text-gray-600">{{ Str::limit($book->description, 50) }}</p>
                                <x-button href="/books/{{ $book->id }}" class="btn btn-primary btn-sm mt-4">View Details
                                </x-button>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <footer class="text-center text-sm text-gray-500 bg-white py-4 shadow w-full">
            Created by Nuno Salavessa Mota using Laravel v{{ Illuminate\Foundation\Application::VERSION }} (PHP v{{ PHP_VERSION }})
        </footer>
    </body>
</html>
