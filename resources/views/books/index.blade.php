<!-- resources/views/books/index.blade.php -->
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

                    <form action="{{ route('books.index') }}" method="GET" class="p-6">

                        <h1 class="my-3 font-extrabold">Search Filters:</h1>
                        <div class="grid grid-cols-3 gap-4">
                            <div>
                                <label for="isbn" class="block font-medium">ISBN</label>
                                <input type="text" name="isbn" id="isbn" value="{{ request('isbn') }}" class="w-full border-gray-300 rounded">
                            </div>
                            <div>
                                <label for="name" class="block font-medium">Name</label>
                                <input type="text" name="name" id="name" value="{{ request('name') }}" class="w-full border-gray-300 rounded">
                            </div>
                            <div>
                                <label for="publisher" class="block font-medium">Publisher</label>
                                <input type="text" name="publisher" id="publisher" value="{{ request('publisher') }}" class="w-full border-gray-300 rounded">
                            </div>
                            <div>
                                <label for="description" class="block font-medium">Description</label>
                                <input type="text" name="description" id="description" value="{{ request('description') }}" class="w-full border-gray-300 rounded">
                            </div>
                        </div>
                        <div class="mt-4">
                            <x-button type="submit">Search</x-button>
                        </div>
                    </form>

                    <div class="overflow-x-auto p-6">
                        <table class="table w-full border-collapse border border-gray-300">
                            <thead>
                            <tr class="bg-gray-200 text-black">
                                <th class="border border-gray-300 p-2">ISBN</th>
                                <th class="border border-gray-300 p-2">Name</th>
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
                                    <td class="border border-gray-300 p-2">{{ $book->publisher->name }}</td>
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
                        {{ $books->appends(request()->query())->links() }}
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
