<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Author Details
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="card bg-gray-300 shadow-xl space-y-6 p-6">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                    <strong class="text-bold text-gray-900">Title:</strong>
                    <p class="text-gray-500">{{ $author->name }}</p>
                </div>

                <figure class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                    <strong class="text-bold text-gray-900">Cover:</strong>
                    <img src="{{ $author->photo }}" alt="Author Photo" class="rounded-lg shadow-md mx-auto">
                </figure>

                <div class="flex justify-between">
                    <p class="mt-6">
                        <x-button href="/authors">Back</x-button>
                    </p>

                    <p class="mt-6">
                        <x-button href="/authors/{{ $author->id }}/edit">Edit author</x-button>
                    </p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
