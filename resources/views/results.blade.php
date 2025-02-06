<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Books
            </h2>
            <x-button href="/books/create">Register book</x-button>
        </div>
    </x-slot>

    <div class="py-12 text-black">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 bg-white border border-gray-200">

                    <div class="overflow-x-auto p-6">
                        <table class="table w-full border-collapse border border-gray-300">
                            <thead>
                            <tr class="bg-gray-200 text-black">
                                <th class="border border-gray-300 p-2">ISBN</th>
                                <th class="border border-gray-300 p-2">Name</th>
                                <th class="border border-gray-300 p-2">Authors</th>
                                <th class="border border-gray-300 p-2">Publisher</th>
                                <th class="border border-gray-300 p-2">Description</th>
                                <th class="border border-gray-300 p-2">Cover</th>
                                <th class="border border-gray-300 p-2">Price</th>
                                <th class="border border-gray-300 p-2"></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($books as $book)
                                <tr class="hover:bg-gray-100">
                                    <td class="border border-gray-300 p-2">{{ $book->isbn }}</td>
                                    <td class="border border-gray-300 p-2">{{ $book->name }}</td>
                                    <td class="border border-gray-300 p-2">
                                        @foreach($book->authors as $author)
                                            <a href="/authors/{{ $author->id }}" class="hover:underline">{{ $author->name }}</a>
                                            <br/>
                                        @endforeach
                                    </td>
                                    <td class="border border-gray-300 p-2">
                                        <a href="/publishers/{{ $book->publisher_id }}" class="hover:underline">{{ $book->publisher->name }}</a>
                                        <br/>
                                    </td>
                                    <td class="border border-gray-300 p-2">{{ \Illuminate\Support\Str::limit($book->description, 50) }}</td>
                                    <td class="border border-gray-300 p-2">
                                        <div class="flex justify-center">
                                            @if($book->cover_image)
                                                <img src="{{ $book->cover_image }}" alt="{{ $book->name }} cover" class="h-12 w-auto p-2">
                                            @else
                                                <span class="text-gray-400 p-2">No Image</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="border border-gray-300 p-2">${{ number_format($book->price, 2) }}</td>
                                    <td class="border border-gray-300 p-2">
                                        <x-button href="/books/{{ $book->id }}" class="btn btn-primary btn-sm p-2">Details</x-button>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div>
                        {{ $books->links() }}
                    </div>
                </div>

                <div class="text-center">
                    <p class="my-3 mx-auto">
                        <x-button href="/dashboard">Home</x-button>
                    </p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
