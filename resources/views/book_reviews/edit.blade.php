<x-app-layout>
    <x-slot name="header">
        <h2 class="text-black text-3xl font-bold">
            Check Review for book: {{ $bookReview->book->name }}
        </h2>
    </x-slot>

    <div class="py-12 px-1">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="card bg-gray-300 shadow-xl space-y-6 p-6">

                @if(Auth::user()->hasRole('citizen'))
                    <form method="POST" action="{{ route('book_reviews.update', $bookReview) }}" class="space-y-6">
                        @csrf
                        @method('PATCH')

                        {{--                        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">--}}
                        {{--                            <label for="rating" class="block text-sm font-medium text-gray-900">Rating</label>--}}
                        {{--                            <input--}}
                        {{--                                type="number"--}}
                        {{--                                name="rating"--}}
                        {{--                                id="rating"--}}
                        {{--                                class="rounded-lg w-full mt-2"--}}
                        {{--                                placeholder="Enter rating"--}}
                        {{--                                step="1"--}}
                        {{--                                value="{{ $bookReview->rating }}"--}}
                        {{--                                required>--}}
                        {{--                            @error('rating') <p class="text-xs text-red-500 font-semibold mt-1">{{ $message }}</p> @enderror--}}
                        {{--                        </div>--}}

                        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                            <label for="rating" class="block text-bold text-gray-900">Rating</label>
                            <input type="hidden" name="rating" id="rating" value="{{ $bookReview->rating }}">
                            <div id="star-rating" class="flex space-x-1 mt-2">
                                <i class="far fa-star cursor-pointer text-gray-400" data-value="1"></i>
                                <i class="far fa-star cursor-pointer text-gray-400" data-value="2"></i>
                                <i class="far fa-star cursor-pointer text-gray-400" data-value="3"></i>
                                <i class="far fa-star cursor-pointer text-gray-400" data-value="4"></i>
                                <i class="far fa-star cursor-pointer text-gray-400" data-value="5"></i>
                            </div>
                        </div>

                        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                            <label for="comment" class="block text-bold text-gray-900">Comment:</label>
                            <textarea
                                name="comment"
                                id="comment"
                                class="rounded-lg w-full mt-2"
                                placeholder="Enter a comment..."
                                required>{{ $bookReview->comment }}</textarea>
                            @error('comment') <p
                                class="text-xs text-red-500 font-semibold mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                            <strong class="text-bold text-gray-900">Status:</strong>
                            <article class="text-gray-500">{{ $bookReview->status }}</article>
                        </div>

                        <input type="hidden" name="status" value="{{ $bookReview->status }}">
                        <input type="hidden" name="justification" value="{{ $bookReview->justification }}">

                        <div class="flex flex-col sm:flex-row gap-4 mb-6 text-center justify-between">
                            <x-button href="{{ route('book_requests.index') }}">Back</x-button>
                            <x-button type="submit">Save Changes</x-button>
                        </div>

                        <x-flash-message type="success"/>
                    </form>
                @else
                    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                        <strong class="text-bold text-gray-900">Rating:</strong>
                        <p class="text-gray-500">{{ $bookReview->rating }}</p>
                    </div>
                    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                        <strong class="text-bold text-gray-900">Comment:</strong>
                        <article class="text-gray-500">{{ $bookReview->comment }}</article>
                    </div>

                    <form method="POST" action="{{ route('book_reviews.update', $bookReview) }}" class="space-y-6">
                        @csrf
                        @method('PATCH')

                        <input type="hidden" name="rating" value="{{ $bookReview->rating }}">
                        <input type="hidden" name="comment" value="{{ $bookReview->comment }}">

                        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                            <label for="status" class="font-bold text-gray-700">Change review status:</label>
                            <select name="status" id="status" class="border border-gray-300 rounded-lg pr-8">
                                <option value="pending" {{ $bookReview->status == 'pending' ? 'selected' : '' }}>
                                    Pending
                                </option>
                                <option value="approved" {{ $bookReview->status == 'approved' ? 'selected' : '' }}>
                                    Approved
                                </option>
                                <option value="refused" {{ $bookReview->status == 'refused' ? 'selected' : '' }}>
                                    Refused
                                </option>
                            </select>
                        </div>

                        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                            <label for="justification"
                                   class="block text-sm font-medium text-gray-900">Justification</label>
                            <input type="text" name="justification" id="justification" class="rounded-lg w-full mt-2"
                                   placeholder="Enter justification..." value="{{ $bookReview->justification }}"
                                   required>
                            @error('justification') <p
                                class="text-xs text-red-500 font-semibold mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="flex flex-col sm:flex-row gap-4 mb-6 text-center justify-between">
                            <x-button href="{{ route('admin_panel') }}">Back</x-button>
                            <x-button type="submit">Save Changes</x-button>
                        </div>
                        @if(session('success'))
                            <div class="bg-green-500 text-white text-center p-3 rounded-lg mb-4">
                                {{ session('success') }}
                            </div>
                        @endif
                    </form>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const ratingInput = document.getElementById('rating');
        const stars = document.querySelectorAll('#star-rating i');

        function updateStars(rating) {
            stars.forEach(star => {
                if (parseInt(star.getAttribute('data-value')) <= rating) {
                    star.classList.remove('far', 'text-gray-400');
                    star.classList.add('fas', 'text-yellow-500');
                } else {
                    star.classList.remove('fas', 'text-yellow-500');
                    star.classList.add('far', 'text-gray-400');
                }
            });
        }

        const currentRating = parseInt(ratingInput.value);
        if (!isNaN(currentRating) && currentRating > 0) {
            updateStars(currentRating);
        }

        stars.forEach(star => {
            star.addEventListener('click', function () {
                const rating = this.getAttribute('data-value');
                ratingInput.value = rating;
                updateStars(rating);
            });
        });
    });
</script>
