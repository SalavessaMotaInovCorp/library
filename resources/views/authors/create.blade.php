<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Register a new book
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="card bg-gray-300 shadow-xl space-y-6 p-6">

                <form method="POST" action="/authors" class="space-y-6">
                    @csrf

                    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                        <label for="title" class="block text-sm font-medium text-gray-900">Name</label>
                        <input
                            type="text"
                            name="name"
                            id="name"
                            class="input input-bordered w-full mt-2"
                            placeholder="Enter book name"
                            required>
                        @error('name')
                        <p class="text-xs text-red-500 font-semibold mt-1">{{ $message }}</p>
                        @enderror
                    </div>


                    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                        <label for="photo" class="block text-sm font-medium text-gray-900">Author photo URL</label>
                        <input type="text" name="photo" id="photo" class="input input-bordered w-full mt-2"
                               placeholder="Enter Author Photo URL" required>
                        @error('photo') <p class="text-xs text-red-500 font-semibold mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="flex justify-between items-center mt-6">
                        <x-button href="/authors" class="btn btn-outline btn-sm">Back</x-button>

                        <div class="flex gap-4">
                            <x-button type="submit" class="btn btn-primary">Save</x-button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
