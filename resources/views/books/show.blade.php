<x-app-layout>
    <x-slot name="header">
        <h2 class="text-black text-3xl font-bold">
            Book Details
        </h2>
    </x-slot>

    <div class="py-12 px-1">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="card bg-gray-300 shadow-xl space-y-6 p-6">

                <x-section title="Title">
                    {{ $book->name }}
                </x-section>

                <x-section title="Cover">
                    <div class="text-center">
                        <img src="{{ asset($book->cover_image) }}" alt="Book Cover"
                             class="rounded-lg shadow-md mx-auto w-1/2 object-contain">
                    </div>
                </x-section>

                <x-section title="ISBN">
                    {{ $book->isbn }}
                </x-section>

                <x-section title="Author(s)">
                    @foreach($authors as $author)
                        <a href="/authors/{{ $author->id }}">
                            <p class="text-gray-500 hover:underline">{{ $author->name }}</p>
                        </a>
                    @endforeach
                </x-section>

                <x-section title="Publisher">
                    <a href="/publishers/{{ $book->publisher->id }}">
                        <p class="text-gray-500 hover:underline">{{ $book->publisher->name }}</p>
                    </a>
                </x-section>

                <x-section title="Description">
                    {{ $book->description }}
                </x-section>

                <x-section title="Price">
                    {{ number_format($book->price, 2) }} €
                </x-section>

                @auth

                    @if ($book_reviews->isNotEmpty())

                        <x-section title="Average Rating">
                            {!! str_repeat('<i class="fas fa-star text-yellow-500"></i>', floor($book->average_rating)) !!}
                            {!! str_repeat('<i class="far fa-star text-gray-400"></i>', 5 - floor($book->average_rating)) !!}
                            ({{ number_format($book->average_rating, 1) }}/5)
                        </x-section>

                        <x-section title="Reviews">
                            <div class="space-y-4">
                                @foreach ($book_reviews as $review)
                                    <div class="border border-gray-300 p-4 rounded-lg shadow-sm">
                                        <p class="text-sm text-gray-600">
                                            <strong class="text-gray-900">{{ $review->user->name }}</strong> -
                                            <span class="text-yellow-500"><i class="fas fa-star text-yellow-500"></i> {{ $review->rating }}/5</span>
                                        </p>
                                        <p class="text-gray-700 mt-1">{{ $review->comment }}</p>
                                    </div>
                                @endforeach
                            </div>
                            <div class="mt-4">
                                {{ $book_reviews->links() }}
                            </div>
                        </x-section>
                    @else
                        <x-section title="Reviews">
                            <div class="text-center">
                                No reviews yet. Be the first to review this book (after you have
                                read it)!
                            </div>
                        </x-section>
                    @endif



                        <script type="text/javascript" src="https://www.google.com/books/jsapi.js"></script>
                        <script type="text/javascript">
                            google.books.load();

                            function initialize() {
                                var viewer = new google.books.DefaultViewer(document.getElementById('viewerCanvas'));
                                viewer.load('{{ $book->isbn }}');
                            }

                            google.books.setOnLoadCallback(initialize);

                        </script>
                    <div id="previewContainer">
                        <x-section title="Preview">
                            <div id="viewerCanvas"
                                 class="w-full max-w-[800px] aspect-[1/1.3] mx-auto shadow-lg rounded-lg bg-white overflow-auto">
                            </div>
                        </x-section>
                    </div>

                    @if($relatedBooks->isNotEmpty())
                        <x-section title="Related Books">
                            <div class="grid gap-6 md:grid-cols-3 lg:grid-cols-4 mt-3">
                                @foreach($relatedBooks as $relatedBook)
                                    <x-book-card :book="$relatedBook"/>
                                @endforeach
                            </div>
                        </x-section>
                    @endif


                    @if(Auth::user()->hasRole('admin'))

                        <x-section title="Requests">
                            <div class="text-center">
                                <a href="/book-requests/{{ $book->id }}/history" class="hover:underline">
                                    <strong class="cursor-pointer">See Requests History</strong>
                                </a>                            </div>
                        </x-section>
                    @elseif($book->in_stock)
                        <x-section title="Requests">
                            <div class="text-center">
                                @if ($hasActiveRequest)
                                    <p class="text-gray-900 font-semibold">You already have an active request for this book.</p>
                                @elseif ($isBookRequestedByOthers)
                                    <p class="text-gray-900 font-semibold">This book is currently requested by another user.</p>
                                    <form action="{{ route('books.markInterest', $book) }}" method="POST">
                                        @csrf
                                        @if(auth()->user()->interestedBooks->contains($book))
                                            <p class="mt-3">You will be notified when this book is available.</p>
                                        @else
                                            <x-button type="submit" class="mt-3">Notify me when available</x-button>
                                        @endif
                                    </form>
                                @else
                                    @php
                                        $activeRequests = Auth::user()->bookRequests()
                                            ->whereIn('status', ['active', 'pending_return_confirm'])
                                            ->count();
                                    @endphp

                                    @if ($activeRequests < 3)
                                        <label for="confirm-request-{{ $book->id }}"
                                               class="items-center px-4 py-2 bg-gray-800 mx-1 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest
                                           hover:bg-gray-700 hover:shadow-lg focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-offset-2
                                           disabled:opacity-50 transition ease-in-out duration-150 transform hover:-translate-y-1 active:scale-95 text-center cursor-pointer">
                                            Request this book
                                        </label>
                                        <input type="checkbox" id="confirm-request-{{ $book->id }}" class="modal-toggle"/>


                                        <div class="modal">
                                            <div class="modal-box text-white">
                                                <h3 class="font-bold text-lg">Confirm Book Request</h3>
                                                <p class="py-4">Are you sure you want to request the book:
                                                    <strong>{{ $book->name }}</strong>?</p>
                                                <div class="modal-action flex justify-between">
                                                    <label for="confirm-request-{{ $book->id }}"
                                                           class="btn bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Cancel</label>
                                                    <form method="POST"
                                                          action="{{ route('book_requests.request', $book->id) }}">
                                                        @csrf
                                                        <x-button type="submit">Confirm</x-button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>

                                    @else
                                        <p class="text-red-500 font-semibold">No more requests available.</p>
                                    @endif
                                @endif
                            </div>
                        </x-section>

                        @if(!$hasActiveRequest && !$isBookRequestedByOthers && $book->in_stock && !$alreadyInCart)
                            <x-section title="Shop">
                                <div class="text-center">
                                    <form method="POST" action="{{ route('cart.add') }}">
                                        @csrf
                                        <input type="hidden" name="book_id" value="{{ $book->id }}">
                                        <x-button type="submit">Add to shopping cart</x-button>
                                    </form>
                                </div>
                            </x-section>
                        @endif
                    @else
                            <x-section title="">
                                <div class="text-center">
                                    This book is not available at the moment.
                                </div>
                            </x-section>
                    @endif
                @endauth
                @guest
                    <x-section title="">
                        <div class="text-center">
                            <p class="text-gray-500">Register or Log In to request or buy this book.</p>
                            <div class="mt-6">
                                <x-button href="{{ route('register') }}">Register</x-button>
                                <x-button href="{{ route('login') }}">Log in</x-button>
                            </div>
                        </div>
                    </x-section>
                @endguest


                <div class="flex flex-col sm:flex-row gap-4 mb-6 text-center justify-between">
                    <x-button href="/books">Books List</x-button>

                    @auth
                        <x-button href="{{ route('dashboard') }}">Home</x-button>
                    @else
                        <x-button href="/">Home</x-button>
                    @endauth

                    @can('update')
                        <x-button href="/books/{{ $book->id }}/edit">Edit book</x-button>
                    @endcan
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
