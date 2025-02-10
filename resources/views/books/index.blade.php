<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Books
            </h2>
            @auth
                @if(Auth::user()->hasRole('admin'))
                    <x-button href="{{ route('books.export') }}">Export CSV/Excel</x-button>
                    <x-button href="/books/create">Register book</x-button>
                @endif
            @endauth
        </div>
    </x-slot>

    <div class="py-12 text-black">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="bg-white shadow-sm sm:rounded-lg p-6">
                    @livewire('books-table')
                </div>

                <div class="text-center">
                    <p class="my-3 mx-auto">
                        @auth
                            <x-button href="{{ route('dashboard') }}">Home</x-button>
                        @else
                            <x-button href="/">Home</x-button>
                        @endauth
                    </p>
                </div>

            </div>
        </div>
    </div>

</x-app-layout>


