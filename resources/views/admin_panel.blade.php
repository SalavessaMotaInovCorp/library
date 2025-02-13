<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="text-black text-3xl font-bold">
                ADMIN PANEL
            </h2>
        </div>
    </x-slot>

    <div class="py-12 text-black bg-gray-100">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">

                <div class="text-center">
                    <x-button href="/create-admin" class="p-12 min-h-32 flex flex-col items-center justify-center rounded-lg shadow-lg">
                        <h3 class="text-2xl font-bold">Register a New Admin</h3>
                    </x-button>
                </div>

                <div class="bg-white shadow-sm sm:rounded-lg p-6">
                    @livewire('users-table')
                </div>

                <div class="flex justify-between">
                    <p class="mt-6">
                        <x-button href="{{ url()->previous() }}">Back</x-button>
                    </p>

                    <p class="mt-6">
                        <x-button href="{{ route('dashboard') }}">Home</x-button>
                    </p>
                </div>

            </div>
        </div>
    </div>

</x-app-layout>


