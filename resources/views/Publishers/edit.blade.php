<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Publisher: {{ $publisher->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="card bg-gray-300 shadow-xl space-y-6 p-6">

                <form method="POST" action="/publishers/{{ $publisher->id }}" class="space-y-6">
                    @csrf
                    @method('PATCH')

                    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                        <label for="name" class="block text-sm font-medium text-gray-900">Name</label>
                        <input type="text" name="name" id="name" class="input input-bordered w-full mt-2"
                               placeholder="Enter book name" value="{{ $publisher->name }}" required>
                        @error('name') <p class="text-xs text-red-500 font-semibold mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                        <label for="logo" class="block text-sm font-medium text-gray-900">Cover Image URL</label>
                        <input type="text" name="logo" id="logo" class="input input-bordered w-full mt-2"
                               placeholder="Enter Cover Image URL" value="{{ $publisher->logo }}" required>
                        @error('logo') <p class="text-xs text-red-500 font-semibold mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="flex justify-between items-center mt-6">
                        <x-button href="/publishers/{{ $publisher->id }}" class="btn btn-outline btn-sm">Back</x-button>
                        <div class="flex gap-4">
                            <x-button type="submit" class="btn btn-primary">Save Changes</x-button>
                            <x-button form="delete-form" class="btn btn-error">Delete</x-button>
                        </div>
                    </div>
                </form>

                <form method="POST" action="/publishers/{{ $publisher->id }}" id="delete-form" class="hidden">
                    @csrf
                    @method('DELETE')
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
