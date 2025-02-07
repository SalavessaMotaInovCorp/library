<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Register a new book
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="card bg-gray-300 shadow-xl space-y-6 p-6">

                <form method="POST" action="/books" class="space-y-6">
                    @csrf

                    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                        <label for="isbn" class="block text-sm font-medium text-gray-900">ISBN</label>
                        <input
                            type="text"
                            name="isbn"
                            id="isbn"
                            class="rounded-lg w-full mt-2"
                            placeholder="Enter ISBN"
                            required>
                        @error('isbn')
                        <p class="text-xs text-red-500 font-semibold mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                        <label for="title" class="block text-sm font-medium text-gray-900">Name</label>
                        <input
                            type="text"
                            name="name"
                            id="name"
                            class="rounded-lg w-full mt-2"
                            placeholder="Enter book name"
                            required>
                        @error('name')
                        <p class="text-xs text-red-500 font-semibold mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                        <label for="description" class="block text-sm font-medium text-gray-900">Description</label>
                        <textarea
                            name="description"
                            id="description"
                            class="rounded-lg w-full mt-2"
                            placeholder="Enter book description"
                            required></textarea>
                        @error('description')
                        <p class="text-xs text-red-500 font-semibold mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                        <label for="cover_image" class="block text-sm font-medium text-gray-900">Cover Image URL</label>
                        <input type="text" name="cover_image" id="cover_image" class="rounded-lg w-full mt-2"
                               placeholder="Enter Cover Image URL" required>
                        @error('cover_image') <p class="text-xs text-red-500 font-semibold mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                        <label class="block text-sm font-medium text-gray-900">Authors</label>
                        <div class="grid grid-cols-2 gap-2 mt-2">
                            @foreach($authors as $author)
                                <label class="flex items-center space-x-2 cursor-pointer">
                                    <input type="checkbox" name="authors[]" value="{{ $author->id }}" class="checkbox checkbox-primary"
                                        {{ in_array($author->id, old('authors', [])) ? 'checked' : '' }}>
                                    <span class="text-sm">{{ $author->name }}</span>
                                </label>
                            @endforeach
                        </div>

                        <div class="mt-4">
                            {{ $authors->links() }}
                        </div>

                        @error('authors') <p class="text-xs text-red-500 font-semibold mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                        <label for="publisher_id" class="block text-sm font-medium text-gray-900">Publisher</label>
                        <select name="publisher_id" id="publisher_id" class="rounded-lg w-full mt-2" required>
                            <option value="" disabled selected>Select a Publisher</option>
                            @foreach($publishers as $publisher)
                                <option value="{{ $publisher->id }}">{{ $publisher->name }}</option>
                            @endforeach
                        </select>
                        @error('publisher_id') <p class="text-xs text-red-500 font-semibold mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                        <label for="price" class="block text-sm font-medium text-gray-900">Price</label>
                        <input
                            type="number"
                            name="price"
                            id="price"
                            class="rounded-lg w-full mt-2"
                            placeholder="Enter book price"
                            step="0.01"
                            required>
                        @error('price')
                        <p class="text-xs text-red-500 font-semibold mt-1">{{ $message }}</p>
                        @enderror
                    </div>


                    <div class="flex justify-between items-center mt-6">
                        <x-button href="/books" class="btn btn-outline btn-sm">Back</x-button>

                        <div class="flex gap-4">
                            <x-button type="submit" class="btn btn-primary">Save</x-button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>


