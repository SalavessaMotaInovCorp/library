<x-app-layout>
    <x-slot name="header">
        <h2 class="text-black text-3xl font-bold">
            Edit Book: {{ $book->name }}
        </h2>
    </x-slot>

    <div class="py-12 px-1">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="card bg-gray-300 shadow-xl space-y-6 p-6">

                <form method="POST" action="/books/{{ $book->id }}" class="space-y-6">
                    @csrf
                    @method('PATCH')

                    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                        <label for="isbn" class="block text-sm font-medium text-gray-900">ISBN</label>
                        <input type="text" name="isbn" id="isbn" class="rounded-lg w-full mt-2"
                               placeholder="Enter ISBN" value="{{ $book->isbn }}" required>
                        @error('isbn') <p class="text-xs text-red-500 font-semibold mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                        <label for="name" class="block text-sm font-medium text-gray-900">Name</label>
                        <input type="text" name="name" id="name" class="rounded-lg w-full mt-2"
                               placeholder="Enter book name" value="{{ $book->name }}" required>
                        @error('name') <p class="text-xs text-red-500 font-semibold mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                        <label for="description" class="block text-sm font-medium text-gray-900">Description</label>
                        <textarea name="description" id="description" class="rounded-lg w-full mt-2"
                                  placeholder="Enter book description" required>{{ $book->description }}</textarea>
                        @error('description') <p class="text-xs text-red-500 font-semibold mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                        <label for="cover_image" class="block text-sm font-medium text-gray-900">Cover Image URL</label>
                        <input type="text" name="cover_image" id="cover_image" class="rounded-lg w-full mt-2"
                               placeholder="Enter Cover Image URL" value="{{ $book->cover_image }}" required>
                        @error('cover_image') <p class="text-xs text-red-500 font-semibold mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                        <label for="price" class="block text-sm font-medium text-gray-900">Price</label>
                        <input type="number" name="price" id="price" class="rounded-lg w-full mt-2"
                               placeholder="Enter book price" step="0.01" value="{{ $book->price }}" required>
                        @error('price') <p class="text-xs text-red-500 font-semibold mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                        <label class="block text-sm font-medium text-gray-900">Authors</label>

                        <div class="max-h-80 overflow-y-auto border rounded-lg p-2 mt-2">
                            <div class="grid grid-cols-2 gap-2">
                                @foreach($authors as $author)
                                    <label class="flex items-center space-x-2 cursor-pointer">
                                        <input
                                            type="checkbox"
                                            name="authors[]"
                                            value="{{ $author->id }}"
                                            class="checkbox"
                                            {{ in_array($author->id, old('authors', $bookAuthorsIds)) ? 'checked' : '' }}>
                                        <span class="text-sm">{{ $author->name }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        @error('authors')
                        <p class="text-xs text-red-500 font-semibold mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                        <label for="publisher_id" class="block text-sm font-medium text-gray-900">Publisher</label>
                        <select name="publisher_id" id="publisher_id" class="rounded-lg w-full mt-2" required>
                            <option value="" disabled>Select a Publisher</option>
                            @foreach($publishers as $publisher)
                                <option value="{{ $publisher->id }}"
                                    {{ $book->publisher_id == $publisher->id ? 'selected' : '' }}>
                                    {{ $publisher->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('publisher_id') <p class="text-xs text-red-500 font-semibold mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="flex flex-col sm:flex-row gap-4 mb-6 text-center justify-between">
                        <x-button href="/books/{{ $book->id }}">Back</x-button>
                        <x-button type="submit">Save Changes</x-button>

                        @can('delete')
                            <label for="delete-modal" class="items-center px-4 py-2 mx-1 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest
                    hover:bg-red-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-offset-2 cursor-pointer
                    disabled:opacity-50 transition ease-in-out duration-150
                    transform hover:-translate-y-1 hover:shadow-lg active:scale-95">Delete</label>
                        @endcan
                    </div>
                </form>

                <form method="POST" action="/books/{{ $book->id }}" id="delete-form" class="hidden">
                    @csrf
                    @method('DELETE')
                </form>

                <input type="checkbox" id="delete-modal" class="modal-toggle" />
                <div class="modal">
                    <div class="modal-box">
                        <h3 class="font-bold text-lg text-red-600">Confirm Delete</h3>
                        <p class="py-4 text-white">Are you sure you want to delete the book <strong>{{ $book->name }}</strong>?</p>
                        <div class="modal-action">
                            <label for="delete-modal" class="btn">Cancel</label>
                            <x-button onclick="document.getElementById('delete-form').submit();" class="btn btn-error bg-red-600">Yes, Delete</x-button>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
