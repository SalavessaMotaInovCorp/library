<x-app-layout>
    <x-slot name="header">
        <h2 class="text-black text-3xl font-bold text-center">
            Leave a review
        </h2>
    </x-slot>

    <div class="py-12 px-1">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="card bg-gray-300 shadow-xl space-y-6 p-6">

                <form method="POST" action="{{ route('book_reviews.store', $book) }}" class="space-y-6">
                    @csrf

                    {{--                    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">--}}
                    {{--                        <label for="rating" class="block text-sm font-medium text-gray-900">Rating</label>--}}
                    {{--                        <input--}}
                    {{--                            type="number"--}}
                    {{--                            name="rating"--}}
                    {{--                            id="rating"--}}
                    {{--                            class="rounded-lg w-full mt-2"--}}
                    {{--                            placeholder="Enter rating"--}}
                    {{--                            step="1"--}}
                    {{--                            required>--}}
                    {{--                        @error('rating')--}}
                    {{--                        <p class="text-xs text-red-500 font-semibold mt-1">{{ $message }}</p>--}}
                    {{--                        @enderror--}}
                    {{--                    </div>--}}

                    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                        <label for="rating" class="block text-sm font-medium text-gray-900">Rating</label>
                        <input type="hidden" name="rating" id="rating" value="0">
                        <div id="star-rating" class="flex space-x-1 mt-2">
                            <i class="far fa-star cursor-pointer text-gray-400" data-value="1"></i>
                            <i class="far fa-star cursor-pointer text-gray-400" data-value="2"></i>
                            <i class="far fa-star cursor-pointer text-gray-400" data-value="3"></i>
                            <i class="far fa-star cursor-pointer text-gray-400" data-value="4"></i>
                            <i class="far fa-star cursor-pointer text-gray-400" data-value="5"></i>
                        </div>
                    </div>


                    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                        <label for="description" class="block text-sm font-medium text-gray-900">Comment:</label>
                        <textarea
                            name="comment"
                            id="comment"
                            class="rounded-lg w-full mt-2"
                            placeholder="Write a comment..."></textarea>
                        @error('comment')
                        <p class="text-xs text-red-500 font-semibold mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        @error('authors')
                        <p class="text-xs text-red-500 font-semibold mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex justify-between items-center mt-6">
                        <x-button href="{{ route('book_requests.index') }}">Back</x-button>

                        <div class="flex gap-4">
                            <x-button type="submit">Save</x-button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const stars = document.querySelectorAll('#star-rating i');
        stars.forEach(star => {
            star.addEventListener('click', function () {
                const rating = this.getAttribute('data-value');
                document.getElementById('rating').value = rating;

                stars.forEach(s => {
                    if (s.getAttribute('data-value') <= rating) {
                        s.classList.remove('far', 'text-gray-400');
                        s.classList.add('fas', 'text-yellow-500');
                    } else {
                        s.classList.remove('fas', 'text-yellow-500');
                        s.classList.add('far', 'text-gray-400');
                    }
                });
            });
        });
    });
</script>
