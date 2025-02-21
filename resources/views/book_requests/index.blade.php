<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="text-black text-3xl font-bold">
                Your Book Requests
            </h2>
        </div>
    </x-slot>

    <div class="py-12 text-black">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 bg-white border border-gray-200">

                    <div class="flex flex-col sm:flex-row gap-4 mb-6 text-center justify-between px-2">
                        <div class="bg-gray-200 p-4 rounded-lg shadow">
                            <p class="text-lg font-bold">{{ $activeRequests }}</p>
                            <p class="text-sm">Active Requests</p>
                        </div>
                        <div class="bg-gray-200 p-4 rounded-lg shadow">
                            <p class="text-lg font-bold">{{ $last30DaysRequests }}</p>
                            <p class="text-sm">Requests in Last 30 Days</p>
                        </div>
                        <div class="bg-gray-200 p-4 rounded-lg shadow">
                            <p class="text-lg font-bold">{{ $returnedToday }}</p>
                            <p class="text-sm">Books Returned Today</p>
                        </div>
                    </div>

                    <form method="GET" action="{{ route('book_requests.index') }}"
                          class="mb-6 flex flex-col sm:flex-row items-center justify-start gap-4">
                        <label for="status" class="font-bold text-gray-700">Filter by Status:</label>
                        <select name="status" id="status" class="border border-gray-300 rounded-lg pr-8">
                            <option value="">All Requests</option>
                            <option value="returned" {{ request('status') == 'returned' ? 'selected' : '' }}> Return
                                Confirmed
                            </option>
                            <option
                                value="pending_return_confirm" {{ request('status') == 'pending_return_confirm' ? 'selected' : '' }}>
                                Pending Confirm
                            </option>
                            <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                        </select>
                        <div class="flex flex-col sm:flex-row justify-between w-full">
                            <x-button type="submit" class="mt-1">Apply Filter</x-button>
                            <x-button href="{{ route('book_requests.available') }}" class="mt-1">Make a new Request
                            </x-button>
                        </div>

                    </form>

                    @if ($bookRequests->isEmpty())
                        <p class="text-gray-600">There are no book requests yet.</p>
                    @else
                        <div class="overflow-x-auto p-6">
                            <table class="table w-full border-collapse border border-gray-300 text-center">
                                <thead>
                                <tr class="bg-gray-200 text-black">
                                    <th class="border border-gray-300 p-2">Book Name</th>
                                    <th class="border border-gray-300 p-2">ISBN</th>
                                    <th class="border border-gray-300 p-2">Authors</th>
                                    <th class="border border-gray-300 p-2">Request Date</th>
                                    <th class="border border-gray-300 p-2">Due Date</th>
                                    <th class="border border-gray-300 p-2">Returned</th>
                                    <th class="border border-gray-300 p-2">Return Date</th>
                                    <th class="border border-gray-300 p-2">Number of days</th>
                                    <th class="border border-gray-300 p-2">Confirmed</th>
                                    <th class="border border-gray-300 p-2"></th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($bookRequests as $bookRequest)
                                    <tr class="hover:bg-gray-100">
                                        <td class="border border-gray-300 p-2">{{ $bookRequest->book->name ?? 'N/A' }}</td>
                                        <td class="border border-gray-300 p-2">{{ $bookRequest->book->isbn ?? 'N/A' }}</td>
                                        <td class="border border-gray-300 p-2">
                                            @foreach($bookRequest->book->authors ?? [] as $author)
                                                <a href="/authors/{{ $author->id }}"
                                                   class="hover:underline">- {{ $author->name }}</a><br/>
                                            @endforeach
                                        </td>
                                        <td class="border border-gray-300 p-2">{{ $bookRequest->request_date }}</td>
                                        <td class="border border-gray-300 p-2">{{ $bookRequest->due_date }}</td>
                                        <td class="border border-gray-300 p-2">
                                            {{ $bookRequest->is_returned ? 'Yes' : 'No' }}
                                        </td>
                                        <td class="border border-gray-300 p-2">{{ $bookRequest->return_date }}</td>
                                        <td class="border border-gray-300 p-2">
                                            @if ($bookRequest->is_confirmed)
                                                {{ $bookRequest->total_request_days }}
                                            @else
                                                {{ ceil(\Carbon\Carbon::parse($bookRequest->request_date)->diffInDays(now(), false)) }}
                                            @endif
                                        </td>
                                        <td class="border border-gray-300 p-2">
                                            {{ $bookRequest->is_confirmed ? 'Yes' : 'No' }}
                                        </td>
                                        <td class="border border-gray-300 p-2 text-center font-bold">
                                            @if(!$bookRequest->is_returned)
                                                <label for="return-{{ $bookRequest->book_id }}"
                                                       class="btn text-white px-4 py-2 rounded cursor-pointer">
                                                    Return
                                                </label>
                                                <input type="checkbox" id="return-{{ $bookRequest->book_id }}"
                                                       class="modal-toggle"/>

                                                <div class="modal">
                                                    <div class="modal-box text-white">
                                                        <div class="text-center m-3">
                                                            <h3 class="font-bold text-lg mt-3">Thank you for choosing
                                                                our library! :)</h3>
                                                        </div>
                                                        <form method="POST"
                                                              action="{{ route('book_requests.returnBook', $bookRequest->id) }}">
                                                            @csrf
                                                            <x-button type="submit">Close</x-button>
                                                        </form>
                                                    </div>
                                                </div>

                                            @else
                                                <p class="text-green-500">Returned</p>
                                                @php
                                                    $existingReview = Auth::user()->bookReviews()->where('book_id', $bookRequest->book_id)->first();
                                                @endphp
                                                @if($existingReview)
                                                    <a href="/book-reviews/{{ $existingReview->id }}/edit"
                                                       class="text-xs">
                                                        (Edit Review)
                                                    </a>
                                                @else
                                                    <a href="{{ route('book_reviews.create', ['book' => $bookRequest->book_id]) }}">
                                                        (Review)
                                                    </a>
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
