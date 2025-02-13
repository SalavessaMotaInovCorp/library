<x-app-layout>
    <x-slot name="header">
        <h2 class="text-black text-3xl font-bold">
            Register a new publisher
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="card bg-gray-300 shadow-xl space-y-6 p-6">

                <form method="POST" action="/publishers" class="space-y-6">
                    @csrf

                    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                        <label for="title" class="block text-sm font-medium text-gray-900">Name</label>
                        <input
                            type="text"
                            name="name"
                            id="name"
                            class="rounded-lg w-full mt-2"
                            placeholder="Enter publisher name"
                            required>
                        @error('name')
                        <p class="text-xs text-red-500 font-semibold mt-1">{{ $message }}</p>
                        @enderror
                    </div>


                    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                        <label for="logo" class="block text-sm font-medium text-gray-900">Publisher Logo URL</label>
                        <input type="text" name="logo" id="logo" class="rounded-lg w-full mt-2"
                               placeholder="Enter publisher logo URL" required>
                        @error('logo') <p class="text-xs text-red-500 font-semibold mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="flex justify-between items-center mt-6">
                        <x-button href="/publishers" class="btn btn-outline btn-sm">Back</x-button>

                        <div class="flex gap-4">
                            <x-button type="submit" class="btn btn-primary">Save</x-button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
