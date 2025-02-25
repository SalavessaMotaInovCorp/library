<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="text-black text-3xl font-bold">
                Book Requests History of: {{ $user->name }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12 text-black">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="p-6 bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="bg-white border border-gray-200">
                    @if ($userBookRequests->isEmpty())
                        <p class="text-gray-600">There are no book requests yet.</p>
                    @else
                        <div class="overflow-x-auto p-6">
                            <table class="table w-full border-collapse border border-gray-300 text-center">
                                <thead>
                                <tr class="bg-gray-200 text-black">
                                    <th class="border border-gray-300 p-2">ISBN</th>
                                    <th class="border border-gray-300 p-2">Book Name</th>
                                    <th class="border border-gray-300 p-2">Authors</th>
                                    <th class="border border-gray-300 p-2">Publisher</th>
                                    <th class="border border-gray-300 p-2">Request Date</th>
                                    <th class="border border-gray-300 p-2">Return Date</th>
                                    <th class="border border-gray-300 p-2">Total Request Days</th>
                                    <th class="border border-gray-300 p-2"></th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($userBookRequests as $bookRequest)
                                    <tr class="hover:bg-gray-100">
                                        <td class="border border-gray-300 p-2">{{ $bookRequest->book->isbn ?? 'N/A' }}</td>
                                        <td class="border border-gray-300 p-2">{{ $bookRequest->book->name ?? 'N/A' }}</td>
                                        <td class="border border-gray-300 p-2">
                                            @foreach($bookRequest->book->authors ?? [] as $author)
                                                <a href="/authors/{{ $author->id }}"
                                                   class="hover:underline">{{ $author->name }}</a><br/>
                                            @endforeach
                                        </td>
                                        <td class="border border-gray-300 p-2">
                                            <a href="/publishers/{{ $bookRequest->book->publisher->id ?? '#' }}"
                                               class="hover:underline">
                                                {{ $bookRequest->book->publisher->name ?? 'N/A' }}
                                            </a>
                                        </td>
                                        <td class="border border-gray-300 p-2">{{ $bookRequest->request_date }}</td>
                                        <td class="border border-gray-300 p-2">{{ $bookRequest->return_date }}</td>
                                        <td class="border border-gray-300 p-2">{{ $bookRequest->total_request_days }}</td>
                                        <td class="border border-gray-300 p-2 text-center font-bold">
                                            @if(!$bookRequest->is_returned)
                                                <p clasS="text-yellow-500">Active</p>
                                            @else
                                                @if(!$bookRequest->is_confirmed)
                                                    <p class="text-yellow-500">Pending Return Confirmation</p>
                                                @else
                                                    <p class="text-green-500">Returned</p>
                                                @endif
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif

                    <div>
                        {{ $userBookRequests->links() }}
                    </div>
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
