<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Books
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border border-gray-200">

                    <div class="overflow-x-auto">
                        <table class="table table-zebra w-full border-solid">

                            <thead>
                            <tr>
                                <th>ISBN</th>
                                <th>Name</th>
                                <th>Publisher</th>
                                <th>Description</th>
                                <th>Cover</th>
                                <th>Price</th>
                                <th>Actions</th>
                            </tr>
                            </thead>

                            <tbody>
                            @foreach($books as $book)
                                <tr>
                                    <td>{{ $book->isbn }}</td>
                                    <td>{{ $book->name }}</td>
                                    <td>{{ $book->publisher->name }}</td>
                                    <td>{{ \Illuminate\Support\Str::limit($book->description, 50) }}</td>
                                    <td>
                                        @if($book->cover_image)
                                            <img src="{{ $book->cover_image }}" alt="{{ $book->name }} cover" class="h-12 w-auto">
                                        @else
                                            <span class="text-gray-400">No Image</span>
                                        @endif
                                    </td>
                                    <td>${{ number_format($book->price, 2) }}</td>
                                    <td>
                                        <a href="/books/{{ $book->id }}" class="btn btn-primary btn-sm">View</a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $books->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
