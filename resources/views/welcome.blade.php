<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Inovcorp Library</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet"/>
    <link rel="icon" type="image/png"
          href="https://aircinelmvc.blob.core.windows.net/resources/inovcorp_logo_book_bg_removed.png.png">

    <!-- Styles / Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>
<body class="font-sans antialiased text-gray-900">

<video
    autoplay
    muted
    loop
    style="position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                object-fit: cover;
                z-index: -1;">
    <source src="https://aircinelmvc.blob.core.windows.net/resources/libraryBackgroundVideo.mp4" type="video/mp4">
    Your browser does not support the video tag.
</video>

<div class="relative min-h-screen flex flex-col items-center justify-center m-3">

    <div class="relative w-full max-w-7xl p-6 bg-gray-100 rounded-2xl">

        <header class="text-center">
            <img src="https://aircinelmvc.blob.core.windows.net/resources/inovcorp_logo_book_bg_removed.png.png"
                 alt="library" class="mx-auto w-16">
            <strong class="text-5xl font-extrabold text-gray-900">Welcome to Inovcorp Library</strong><br/>
            <p class="mt-4 text-lg text-gray-700">Register or Log In to explore thousands of books, meet renowned
                authors, and dive into a
                world of knowledge.</p>
            <div class="mt-6">
                <x-button href="{{ route('register') }}" class="btn btn-primary btn-lg">Register</x-button>
                <x-button href="{{ route('login') }}" class="btn btn-primary btn-lg ml-4">Log in</x-button>
            </div>
        </header>

        <h2 class="text-2xl font-bold text-gray-800 mb-3 mt-12">Explore</h2>
        <div class="grid gap-10 md:grid-cols-3 text-center mt-6">
            <x-button href="/books" class="p-6 min-h-32 flex flex-col items-center justify-center rounded-lg shadow-lg">
                <h3 class="text-4xl font-bold">{{ $books_count }}</h3>
                <p class="text-lg">Books Available</p>
            </x-button>

            <x-button href="/authors"
                      class="p-6 min-h-32 flex flex-col items-center justify-center rounded-lg shadow-lg">
                <h3 class="text-4xl font-bold">{{ $authors_count }}</h3>
                <p class="text-lg">Authors</p>
            </x-button>

            <x-button href="/publishers"
                      class="p-6 min-h-32 flex flex-col items-center justify-center rounded-lg shadow-lg">
                <h3 class="text-4xl font-bold">{{ $publishers_count }}</h3>
                <p class="text-lg">Publishers</p>
            </x-button>
        </div>

        <h2 class="text-2xl font-bold text-gray-800 mb-3 mt-12">Latest Additions</h2>

        <x-recent-books-carousel :recentBooks="$recent_books"/>

        <div class="grid gap-6 md:grid-cols-3 lg:grid-cols-4 mb-6 mt-6">
            @foreach($recent_books as $book)
                <div class="card bg-white shadow-xl flex flex-col h-full"> <!-- Flex container -->
                    <figure>
                        <img src="{{ $book->cover_image }}" alt="Book Cover" class="h-48 w-full object-cover">
                    </figure>
                    <div class="p-4 flex flex-col flex-grow"> <!-- Flex-grow para expandir -->
                        <h3 class="text-lg font-bold">{{ $book->name }}</h3>
                        <p class="text-sm text-gray-600 flex-grow">{{ Str::limit($book->description, 50) }}</p>
                        <!-- Ocupar espaço extra -->
                        <x-button href="/books/{{ $book->id }}" class="btn btn-primary btn-sm mt-4 self-start">View
                            Details
                        </x-button>
                    </div>
                </div>
            @endforeach
        </div>


        <section class="bg-gray-200 py-12 px-6 rounded-lg shadow-md">
            <div class="max-w-6xl mx-auto flex flex-col md:flex-row items-center">
                <div class="md:w-1/2 text-center md:text-left mb-6 md:mb-0">
                    <h2 class="text-3xl font-bold text-gray-800 mb-4">About Inovcorp Library</h2>
                    <p class="text-lg text-gray-700 leading-relaxed">
                        Inovcorp Library is a digital space dedicated to book lovers.
                        Here, you can explore a vast collection of books, discover new authors,
                        and easily request book loans.
                    </p>
                    <p class="mt-4 text-lg text-gray-700">
                        Our mission is to promote reading and make literature more accessible to everyone.
                        Join us and experience the joy of reading!
                    </p>
                </div>
                <div class="md:w-1/2 flex justify-center mt-2">
                    <img src="https://aircinelmvc.blob.core.windows.net/resources/librarySample2.jpg"
                         alt="Library Image" class="w-full max-w-md rounded-lg shadow-lg">
                </div>
            </div>
        </section>

    </div>
</div>

<footer class="text-center text-sm text-gray-500 bg-white py-4 mt-4 shadow w-full">
    Created by Nuno Salavessa Mota using Laravel v{{ Illuminate\Foundation\Application::VERSION }} (PHP
    v{{ PHP_VERSION }})
</footer>
</body>
</html>
