<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                @if(Auth::user()->hasRole('admin'))
                    Book Requests
                @endif
            </h2>
        </div>
    </x-slot>

    <div class="py-12 text-black">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 bg-white border border-gray-200">
                    @if ($bookRequests->isEmpty())
                        <p class="text-gray-600">There are no book requests yet.</p>
                    @else
                        <div class="overflow-x-auto p-6">
                            <table class="table w-full border-collapse border border-gray-300">
                                <thead>
                                <tr class="bg-gray-200 text-black">
                                    <th class="border border-gray-300 p-2">ISBN</th>
                                    <th class="border border-gray-300 p-2">Name</th>
                                    <th class="border border-gray-300 p-2">Authors</th>
                                    <th class="border border-gray-300 p-2">Publisher</th>
                                    <th class="border border-gray-300 p-2">Description</th>
                                    <th class="border border-gray-300 p-2">Cover</th>
                                    <th class="border border-gray-300 p-2">Price</th>
                                    <th class="border border-gray-300 p-2"></th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($bookRequests as $bookRequest)
                                    <tr class="hover:bg-gray-100">
                                        <td class="border border-gray-300 p-2">{{ $bookRequest->book->isbn ?? 'N/A' }}</td>
                                        <td class="border border-gray-300 p-2">{{ $bookRequest->book->name ?? 'N/A' }}</td>
                                        <td class="border border-gray-300 p-2">
                                            @foreach($bookRequest->book->authors ?? [] as $author)
                                                <a href="/authors/{{ $author->id }}" class="hover:underline">{{ $author->name }}</a><br/>
                                            @endforeach
                                        </td>
                                        <td class="border border-gray-300 p-2">
                                            <a href="/publishers/{{ $bookRequest->book->publisher->id ?? '#' }}" class="hover:underline">
                                                {{ $bookRequest->book->publisher->name ?? 'N/A' }}
                                            </a>
                                        </td>
                                        <td class="border border-gray-300 p-2">{{ \Illuminate\Support\Str::limit($bookRequest->book->description ?? 'N/A', 50) }}</td>
                                        <td class="border border-gray-300 p-2">
                                            <div class="flex justify-center">
                                                @if ($bookRequest->book && $bookRequest->book->cover_image)
                                                    <img src="{{ $bookRequest->book->cover_image }}" alt="{{ $bookRequest->book->name }} cover" class="h-12 w-auto p-2">
                                                @else
                                                    <span class="text-gray-400 p-2">No Image</span>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="border border-gray-300 p-2">{{ number_format($bookRequest->book->price ?? 0, 2) }} €</td>
                                        <td class="border border-gray-300 p-2 text-center">
                                            @if(!$bookRequest->is_returned)
                                                <form method="POST" action="{{ route('book_requests.returnBook', $bookRequest->id) }}">
                                                    @csrf
                                                    <x-button type="submit">Return Book</x-button>
                                                </form>
                                            @else
                                                <p class="text-green-500">Returned</p>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>

                            </table>
                        </div>
                    @endif
                    <div>
                        {{ $bookRequests->links() }}
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
