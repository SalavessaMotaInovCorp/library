<x-app-layout>
    <x-slot name="header">
        <h2 class="text-black text-3xl font-bold">
            {{ __('Available Books') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                @if ($books->isEmpty())
                    <p class="text-gray-600">No books available at the moment.</p>
                @else
                    <div class="overflow-x-auto p-6">
                        <table class="table w-full text-black">
                            <thead>
                            <tr class="bg-gray-200 text-black">
                                <th class="border border-gray-300 p-2">ISBN</th>
                                <th class="border border-gray-300 p-2">Name</th>
                                <th class="border border-gray-300 p-2">Authors</th>
                                <th class="border border-gray-300 p-2">Publisher</th>
                                <th class="border border-gray-300 p-2">Description</th>
                                <th class="border border-gray-300 p-2">Cover</th>
                                <th class="border border-gray-300 p-2">Details</th>
                                <th class="border border-gray-300 p-2"></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($books as $book)
                                <tr class="hover:bg-gray-100">
                                    <td class="border border-gray-300 p-2">{{ $book->isbn }}</td>
                                    <td class="border border-gray-300 p-2">{{ $book->name }}</td>
                                    <td class="border border-gray-300 p-2">
                                        @foreach($book->authors as $author)
                                            <a href="/authors/{{ $author->id }}"
                                               class="hover:underline">{{ $author->name }}</a><br/>
                                        @endforeach
                                    </td>
                                    <td class="border border-gray-300 p-2">
                                        <a href="/publishers/{{ $book->publisher_id }}"
                                           class="hover:underline">{{ $book->publisher->name }}</a><br/>
                                    </td>
                                    <td class="border border-gray-300 p-2">{{ \Illuminate\Support\Str::limit($book->description, 50) }}</td>
                                    <td class="border border-gray-300 p-2">
                                        <div class="flex justify-center">
                                            @if($book->cover_image)
                                                <img src="{{ $book->cover_image }}" alt="Cover image"
                                                     style="height:60px; cursor:pointer;"
                                                     class="rounded mx-auto hover:shadow-lg transition-transform hover:scale-105">
                                            @else
                                                <span class="text-gray-400 p-2">No Image</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="border border-gray-300 p-2">
                                        <x-button href="/books/{{ $book->id }}"
                                                  class="inline-flex items-center px-4 py-2 bg-gray-800 text-white rounded-md hover:bg-gray-700 focus:ring-2">
                                            Details
                                        </x-button>
                                    </td>
                                    <td class="border border-gray-300 p-2 text-center">
                                        @if(Auth::user()->hasRole('admin'))
                                            <!-- Admin: Show Modal to Select User -->
                                            <label for="admin-request-{{ $book->id }}"
                                                   class="btn text-white px-4 py-2 rounded cursor-pointer ">
                                                Choose a citizen
                                            </label>
                                            <input type="checkbox" id="admin-request-{{ $book->id }}"
                                                   class="modal-toggle"/>

                                            <div class="modal">
                                                <div class="modal-box text-white">
                                                    <p class="py-2">Book: <strong>{{ $book->name }}</strong></p>

                                                    <form method="POST"
                                                          action="{{ route('book_requests.request', $book->id) }}">
                                                        @csrf
                                                        <div class="mb-4">
                                                            @if($citizens->count() < 1)
                                                                <p>No citizens available</p>
                                                            @else
                                                                <label for="user_id" class="block text-sm font-medium">Choose
                                                                    a Citizen:</label>
                                                                <select name="user_id" id="user_id"
                                                                        class="w-full border rounded p-2 text-black">
                                                                    @foreach($citizens as $citizen)
                                                                        <option
                                                                            value="{{ $citizen->id }}">{{ $citizen->name }}
                                                                            ({{ $citizen->email }})
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            @endif
                                                        </div>

                                                        <div class="modal-action flex justify-between">
                                                            <label for="admin-request-{{ $book->id }}"
                                                                   class="btn bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Cancel</label>
                                                            <x-button type="submit">Confirm Request</x-button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>

                                        @else
                                            @php
                                                $activeRequests = Auth::user()->bookRequests()
                                                    ->whereIn('status', ['active', 'pending_return_confirm'])
                                                    ->count();
                                            @endphp

                                            @if ($activeRequests < 3)
                                                <label for="confirm-request-{{ $book->id }}" class="btn text-white px-4 py-2 rounded cursor-pointer">
                                                    Request
                                                </label>
                                                <input type="checkbox" id="confirm-request-{{ $book->id }}" class="modal-toggle"/>

                                                <div class="modal">
                                                    <div class="modal-box text-white">
                                                        <h3 class="font-bold text-lg">Confirm Book Request</h3>
                                                        <p class="py-4">Are you sure you want to request the book:
                                                            <strong>{{ $book->name }}</strong>?</p>
                                                        <div class="modal-action flex justify-between">
                                                            <label for="confirm-request-{{ $book->id }}" class="btn bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Cancel</label>
                                                            <form method="POST" action="{{ route('book_requests.request', $book->id) }}">
                                                                @csrf
                                                                <x-button type="submit">Confirm</x-button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            @else
                                                <p class="text-red-500 font-semibold">No more requests available</p>
                                            @endif
                                        @endif

                                    </td>

                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div>
                        {{ $books->links() }}
                    </div>

                @endif
            </div>
        </div>
    </div>
</x-app-layout>
