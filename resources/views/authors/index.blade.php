<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Authors
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border border-gray-200">

                    <div class="overflow-x-auto">
                        <table class="table table-zebra w-full border-solid">

                            <thead>
                            <tr>
                                <th>Name</th>
                                <th>Photo</th>
                            </tr>
                            </thead>

                            <tbody>
                            @foreach($authors as $author)
                                <tr>
                                    <td>{{ $author->name }}</td>
                                    <td>
                                        @if($author->photo)
                                            <img src="{{ $author->photo }}" alt="{{ $author->name }} photo" class="h-12 w-auto">
                                        @else
                                            <span class="text-gray-400">No Image</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="/books/{{ $author->id }}" class="btn btn-primary btn-sm">View</a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $authors->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
