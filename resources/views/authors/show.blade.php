<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Author Details
        </h2>
    </x-slot>

    <div class="py-12 px-1">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="card bg-gray-300 shadow-xl space-y-6 p-6">

                <x-section title="Name">
                    {{ $author->name }}
                </x-section>

                <x-section title="Photo">
                    <div class="w-full max-w-xs sm:max-w-md md:max-w-lg lg:max-w-xl xl:max-w-2xl mx-auto">
                        <img src="{{ asset($author->photo) }}" alt="Author Photo" class="rounded-lg shadow-md mx-auto w-full h-auto object-contain">
                    </div>
                </x-section>

                <x-section title="Books from this author">
                    @if($books->isEmpty())
                        <p class="text-gray-500 mt-2">This author has no books yet.</p>
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
                </x-section>

                <div class="flex flex-col sm:flex-row gap-4 mb-6 text-center justify-between">
                    <p class="mt-6">
                        <x-button href="/authors">Authors List</x-button>
                    </p>

                    @can('update')
                        <p class="mt-6">
                            <x-button href="/authors/{{ $author->id }}/edit">Edit author</x-button>
                        </p>
                    @endcan

                    @auth
                        <p class="mt-6">
                            <x-button href="/dashboard">Home</x-button>
                        </p>
                    @endauth
                    @guest
                        <p class="mt-6">
                            <x-button href="/">Home</x-button>
                        </p>
                    @endguest
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
