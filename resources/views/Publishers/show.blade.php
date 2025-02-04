<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Publisher Details
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="card bg-gray-300 shadow-xl space-y-6 p-6">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                    <strong class="text-bold text-gray-900">Name:</strong>
                    <p class="text-gray-500">{{ $publisher->name }}</p>
                </div>

                <figure class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                    <strong class="text-bold text-gray-900">Logo:</strong>
                    <img src="{{ $publisher->logo }}" alt="{{ $publisher->name }} logo" class="rounded-lg shadow-md mx-auto">
                </figure>

                <div class="flex justify-between">
                    <p class="mt-6">
                        <x-button href="/publishers">Back</x-button>
                    </p>

                    <p class="mt-6">
                        <x-button href="/publishers/{{ $publisher->id }}/edit">Edit publisher</x-button>
                    </p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
