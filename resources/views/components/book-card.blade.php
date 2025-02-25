<div class="card bg-white shadow-xl flex flex-col h-full">
    <figure>
        <img src="{{ $book->cover_image }}" alt="Book Cover" class="h-48 w-full object-cover">
    </figure>
    <div class="p-4 flex flex-col flex-grow">
        <h3 class="text-lg font-bold">{{ $book->name }}</h3>
        <p class="text-sm text-gray-600 flex-grow">{{ Str::limit($book->description, 50) }}</p>
        <x-button href="/books/{{ $book->id }}" class="btn btn-primary btn-sm mt-4 self-start">
            View Details
        </x-button>
    </div>
</div>
