<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Book: {{ $book->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="card bg-gray-300 shadow-xl space-y-6 p-6">

                <form method="POST" action="/books/{{ $book->id }}" class="space-y-6">
                    @csrf
                    @method('PATCH')

                    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                        <label for="isbn" class="block text-sm font-medium text-gray-900">ISBN</label>
                        <input type="text" name="isbn" id="isbn" class="input input-bordered w-full mt-2"
                               placeholder="Enter ISBN" value="{{ $book->isbn }}" required>
                        @error('isbn') <p class="text-xs text-red-500 font-semibold mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                        <label for="name" class="block text-sm font-medium text-gray-900">Name</label>
                        <input type="text" name="name" id="name" class="input input-bordered w-full mt-2"
                               placeholder="Enter book name" value="{{ $book->name }}" required>
                        @error('name') <p class="text-xs text-red-500 font-semibold mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                        <label for="description" class="block text-sm font-medium text-gray-900">Description</label>
                        <textarea name="description" id="description" class="textarea textarea-bordered w-full mt-2"
                                  placeholder="Enter book description" required>{{ $book->description }}</textarea>
                        @error('description') <p class="text-xs text-red-500 font-semibold mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                        <label for="cover_image" class="block text-sm font-medium text-gray-900">Cover Image URL</label>
                        <input type="text" name="cover_image" id="cover_image" class="input input-bordered w-full mt-2"
                               placeholder="Enter Cover Image URL" value="{{ $book->cover_image }}" required>
                        @error('cover_image') <p class="text-xs text-red-500 font-semibold mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                        <label for="price" class="block text-sm font-medium text-gray-900">Price</label>
                        <input type="number" name="price" id="price" class="input input-bordered w-full mt-2"
                               placeholder="Enter book price" step="0.01" value="{{ $book->price }}" required>
                        @error('price') <p class="text-xs text-red-500 font-semibold mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                        <label for="publisher_id" class="block text-sm font-medium text-gray-900">Publisher</label>
                        <select name="publisher_id" id="publisher_id" class="select select-bordered w-full mt-2" required>
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

                    <div class="flex justify-between items-center mt-6">
                        <x-button href="/books/{{ $book->id }}" class="btn btn-outline btn-sm">Back</x-button>
                        <div class="flex gap-4">
                            <x-button type="submit" class="btn btn-primary">Save Changes</x-button>
                            <x-button form="delete-form" class="btn btn-error">Delete</x-button>
                        </div>
                    </div>
                </form>

                <form method="POST" action="/books/{{ $book->id }}" id="delete-form" class="hidden">
                    @csrf
                    @method('DELETE')
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
