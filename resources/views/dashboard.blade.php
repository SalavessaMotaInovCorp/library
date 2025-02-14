<x-app-layout>
    <style>
        body {
            background-image: none !important;
        }
    </style>

    <video autoplay muted loop class="fixed inset-0 w-full h-full object-cover -z-10">
        <source src="https://aircinelmvc.blob.core.windows.net/resources/libraryBackgroundVideo.mp4" type="video/mp4">
        Your browser does not support the video tag.
    </video>

    <x-slot name="header">
        <div class="bg-cover bg-center">
            <div class="inset-0 flex items-center justify-center">
                <h1 class="text-black text-5xl font-bold">Inovcorp Library</h1>
            </div>
        </div>
    </x-slot>

    <div class="py-3">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-10 py-6">

            <h2 class="text-2xl font-bold text-gray-800 mb-3">Explore</h2>
            <div class="grid gap-10 md:grid-cols-3 text-center">
                <x-button href="/books" class="p-6 min-h-32 flex flex-col items-center justify-center rounded-lg shadow-lg">
                    <h3 class="text-4xl font-bold">{{ $books_count }}</h3>
                    <p class="text-lg">Books Available</p>
                </x-button>

                <x-button href="/authors" class="p-6 min-h-32 flex flex-col items-center justify-center rounded-lg shadow-lg">
                    <h3 class="text-4xl font-bold">{{ $authors_count }}</h3>
                    <p class="text-lg">Authors</p>
                </x-button>

                <x-button href="/publishers" class="p-6 min-h-32 flex flex-col items-center justify-center rounded-lg shadow-lg">
                    <h3 class="text-4xl font-bold">{{ $publishers_count }}</h3>
                    <p class="text-lg">Publishers</p>
                </x-button>
            </div>



            <form action="/search" class="relative flex items-center justify-center mb-6">
                @csrf
                <input type="text" class="input input-bordered w-full max-w-md text-white" name="query" placeholder="Search book name...">
                 <x-button class="btn btn-primary ml-2">🔍 Search</x-button>
            </form>

            <div class="text-center">
                <x-button href="/book-requests/available" class="p-12 min-h-32 flex flex-col items-center justify-center rounded-lg shadow-lg">
                    <h3 class="text-2xl font-bold">Request a Book</h3>
                </x-button>
            </div>

            <h2 class="text-2xl font-bold text-gray-800 mb-3">Recent Books</h2>
            <div class="grid gap-6 md:grid-cols-3 lg:grid-cols-4 mb-6">
                @foreach($recent_books as $book)
                    <div class="card bg-white shadow-xl flex flex-col h-full"> <!-- Flex container -->
                        <figure>
                            <img src="{{ $book->cover_image }}" alt="Book Cover" class="h-48 w-full object-cover">
                        </figure>
                        <div class="p-4 flex flex-col flex-grow"> <!-- Flex-grow para expandir -->
                            <h3 class="text-lg font-bold">{{ $book->name }}</h3>
                            <p class="text-sm text-gray-600 flex-grow">{{ Str::limit($book->description, 50) }}</p> <!-- Ocupar espaço extra -->
                            <x-button href="/books/{{ $book->id }}" class="btn btn-primary btn-sm mt-4 self-start">View Details</x-button>
                        </div>
                    </div>
                @endforeach
            </div>

            @if($readerOfTheMonth)
                <section class="py-6 px-6 rounded-lg shadow-md text-center bg-cover bg-center flex justify-center items-center"
                         style="background-image: url('https://aircinelmvc.blob.core.windows.net/resources/librarySample3.jpg'); min-height: 300px;">

                    <div class="bg-gray-50 bg-opacity-50 backdrop-blur-md p-6 rounded-lg shadow-lg max-w-md w-full">
                        <h2 class="text-2xl font-bold text-gray-800">Reader of the Month</h2>
                        <img src="{{ $readerOfTheMonth->profile_photo_path ?? '/default-avatar.jpg' }}"
                             alt="Reader of the Month" class="w-32 h-42 mx-auto rounded-xl mt-4 shadow-lg border border-black">
                        <h3 class="text-xl font-bold mt-2">{{ $readerOfTheMonth->name }}</h3>
                        <p class="text-gray-900">Read {{ $readerOfTheMonth->book_requests_count }} books this month!</p>
                    </div>

                </section>
            @endif


            <section class="bg-gray-100 py-12 px-6 rounded-lg shadow-md">
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
                             alt="Library Image" class="w-full max-w-md rounded-lg shadow-xl">
                    </div>
                </div>
            </section>



        </div>
    </div>
</x-app-layout>
