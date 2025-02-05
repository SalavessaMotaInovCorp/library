<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Publishers
            </h2>
            <x-button href="/publishers/create">Register publisher</x-button>
        </div>
    </x-slot>

    <div class="py-12 text-black">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 bg-white border border-gray-200">

                    <form action="{{ route('publishers.index') }}" method="GET" class="p-6">
                        <h1 class="my-3 font-extrabold">Search Filters:</h1>
                        <div class="grid grid-cols-3 gap-4">
                            <div>
                                <label for="name" class="block font-medium">Name</label>
                                <input type="text" name="name" id="name" value="{{ request('name') }}" class="w-full border-gray-300 rounded">
                            </div>
                        </div>
                        <div class="mt-4">
                            <x-button type="submit">Search</x-button>
                        </div>
                    </form>

                    <div class="overflow-x-auto">
                        <table class="table w-full border-collapse border border-gray-300">
                            <thead>
                            <tr class="bg-gray-200 text-black">
                                <th class="border border-gray-300 p-2">Name</th>
                                <th class="border border-gray-300 p-2">Photo</th>
                                <th class="border border-gray-300 p-2">Actions</th>
                            </tr>
                            </thead>

                            <tbody>
                            @foreach($publishers as $publisher)
                                <tr class="hover:bg-gray-100">
                                    <td class="border border-gray-300 p-2">{{ $publisher->name }}</td>
                                    <td class="border border-gray-300 p-2">
                                        <div class="flex justify-center">
                                            @if($publisher->logo)
                                                <img src="{{ $publisher->logo }}" alt="{{ $publisher->name }} photo" class="h-12 w-auto">
                                            @else
                                                <span class="text-gray-400">No Image</span>
                                            @endif
                                        </div>
                                    </td>

                                    <td class="border border-gray-300 p-2 text-center">
                                        <x-button href="/publishers/{{ $publisher->id }}" class="btn btn-primary btn-sm">View</x-button>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $publishers->links() }}
                    </div>
                </div>
                <div class="text-center">
                    <p class="my-3 mx-auto">
                        <x-button href="/dashboard">Home</x-button>
                    </p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
