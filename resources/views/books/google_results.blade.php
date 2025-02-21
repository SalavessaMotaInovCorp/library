<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="text-black text-3xl font-bold">
                Main Warehouse Books Search Results
            </h2>
            <x-button href="{{ route('books.index') }}">Back to Local Library</x-button>
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
                                <th class="border border-gray-300 p-2">Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($apiBooks as $book)
                                <tr class="hover:bg-gray-100">
                                    <td class="border border-gray-300 p-2">{{ $book->isbn }}</td>
                                    <td class="border border-gray-300 p-2">{{ $book->name }}</td>
                                    <td class="border border-gray-300 p-2">
                                        @foreach($book->authors as $author)
                                            {{ $author->name }}
                                        @endforeach
                                    </td>
                                    <td class="border border-gray-300 p-2">{{ $book->publisher->name }}</td>

                                    <td class="border border-gray-300 p-2">
                                        <label for="modal-description-{{ $book->isbn }}"
                                               class="mx-auto hover:cursor-pointer">
                                            <p>{{ \Illuminate\Support\Str::limit($book->description, 50) }}</p>
                                        </label>

                                        <input type="checkbox" id="modal-description-{{ $book->isbn }}"
                                               class="modal-toggle"/>

                                        <div class="modal space-y-1" id="modal-description-{{ $book->isbn }}">
                                            <div class="modal-box bg-white">
                                                <div>
                                                    <h3>Description for book:</h3>
                                                    <h3 class="text-lg font-bold mb-4 mx-auto">{{ $book->name }}</h3>
                                                </div>

                                                <p class="rounded-lg shadow-2xl mx-auto w-full border-black p-2">{{ $book->description }}</p>

                                                <label for="modal-description-{{ $book->isbn }}"
                                                       class="btn btn-sm mt-2">Close</label>
                                            </div>
                                        </div>
                                    </td>

                                    <td class="border border-gray-300 p-2 text-center">
                                        <div class="flex justify-center">
                                            @if($book->cover_image)

                                                <label for="modal-cover-{{ $book->isbn }}">
                                                    <img src="{{ $book->cover_image }}" alt="Cover image"
                                                         style="height:60px; cursor:pointer;"
                                                         class="rounded mx-auto hover:shadow-lg transition-transform hover:scale-105">
                                                </label>
                                                <input type="checkbox" id="modal-cover-{{ $book->isbn }}"
                                                       class="modal-toggle"/>

                                                <div class="modal space-y-1" id="modal-cover-{{ $book->isbn }}">
                                                    <div class="modal-box bg-white">
                                                        <div>
                                                            <h3>Cover image for book:</h3>
                                                            <h3 class="text-lg font-bold mb-4 mx-auto">{{ $book->name }}</h3>
                                                        </div>

                                                        <img src="{{ $book->cover_image }}" alt="Cover image"
                                                             class="rounded-lg shadow-2xl mx-auto w-full border-black">

                                                        <label for="modal-cover-{{ $book->isbn }}"
                                                               class="btn btn-sm mt-2">Close</label>
                                                    </div>
                                                </div>

                                            @else
                                                <span class="text-gray-400 p-2">No Image</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="border border-gray-300 p-2 text-center">
                                        @if(isset($book->exists_in_db) && $book->exists_in_db)
                                            <div class="text-center font-bold">Already in our Library</div>
                                        @else
                                            <form action="{{ route('google_books.order') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="isbn" value="{{ $book->isbn }}">
                                                <input type="hidden" name="title" value="{{ $book->name }}">
                                                <input type="hidden" name="publisher"
                                                       value="{{ $book->publisher->name ?? 'Unknown Publisher' }}">
                                                <input type="hidden" name="description"
                                                       value="{{ $book->description }}">
                                                <input type="hidden" name="cover_image"
                                                       value="{{ $book->cover_image }}">
                                                <input type="hidden" name="authors"
                                                       value="{{ json_encode($book->authors->pluck('name')) }}">

                                                <label for="confirm-request-delivery-{{ $book->isbn }}"
                                                       class="btn text-white px-4 py-2 rounded cursor-pointer">
                                                    Import
                                                </label>
                                                <input type="checkbox" id="confirm-request-delivery-{{ $book->isbn }}"
                                                       class="modal-toggle"/>

                                                <div class="modal">
                                                    <div class="modal-box text-white text-center">
                                                        <h3 class="font-bold text-lg">Confirm Book Import Request</h3>
                                                        <p class="py-4">Are you sure you want to import the book:
                                                            <strong>{{ $book->name }}</strong> to our library database?
                                                        </p>
                                                        <div class="modal-action flex justify-between">
                                                            <label for="confirm-request-delivery-{{ $book->isbn }}"
                                                                   class="btn bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Cancel</label>
                                                            <x-button type="submit">Confirm</x-button>
                                                        </div>
                                                        <p class="py-4">The importation is immediate!</p>
                                                    </div>
                                                </div>


                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="flex justify-between">
                        <p class="mt-6">
                            <x-button href="{{ route('admin_panel') }}">Back</x-button>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>


