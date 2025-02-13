<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="text-black text-3xl font-bold">
                @if(Auth::user()->hasRole('admin'))
                    Requests History for Book: {{ $book->name }}
                @endif
            </h2>
        </div>
    </x-slot>

    <div class="py-12 text-black">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 bg-white border border-gray-200">
                    @if ($book->bookRequests()->exists())
                        <div class="overflow-x-auto p-6">
                            <table class="table w-full border-collapse border border-gray-300">
                                <thead>
                                <tr class="bg-gray-200 text-black">
                                    <th class="border border-gray-300 p-2">User Name</th>
                                    <th class="border border-gray-300 p-2">ISBN</th>
                                    <th class="border border-gray-300 p-2">Book Title</th>
                                    <th class="border border-gray-300 p-2">Request Date</th>
                                    <th class="border border-gray-300 p-2">Due Date</th>
                                    <th class="border border-gray-300 p-2">Returned</th>
                                    <th class="border border-gray-300 p-2">Number of days</th>
                                    <th class="border border-gray-300 p-2">Confirmed</th>
                                    <th class="border border-gray-300 p-2"></th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($bookRequests as $bookRequest)
                                    <tr class="hover:bg-gray-100">
                                        <td class="border border-gray-300 p-2">{{ $bookRequest->user_name ?? 'N/A' }}</td>
                                        <td class="border border-gray-300 p-2">{{ $bookRequest->book->isbn ?? 'N/A' }}</td>
                                        <td class="border border-gray-300 p-2">{{ $bookRequest->book->name }}</td>
                                        <td class="border border-gray-300 p-2">{{ $bookRequest->request_date }}</td>
                                        <td class="border border-gray-300 p-2">{{ $bookRequest->due_date }}</td>
                                        <td class="border border-gray-300 p-2">
                                            {{ $bookRequest->is_returned ? 'Yes' : 'No' }}
                                        </td>
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


                                        <td class="border border-gray-300 p-2 text-center">
                                            @if($bookRequest->is_confirmed)
                                                <p class="text-green-500 font-bold">Return Confirmed</p>
                                            @else
                                                @if(!$bookRequest->is_returned)
                                                    <p class="text-yellow-500 font-bold">Active</p>
                                                @else
                                                    <form method="POST" action="{{ route('book_requests.confirmReturn', $bookRequest->id) }}">
                                                        @csrf
                                                        <x-button type="submit">Confirm Return</x-button>
                                                    </form>
                                                @endif
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>

                            </table>
                        </div>
                    @else
                        <p class="text-gray-600">This book has no requests yet.</p>

                    @endif
                    <div>
                        {{ $bookRequests->links() }}
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
    </div>
</x-app-layout>
