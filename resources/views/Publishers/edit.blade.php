<x-app-layout>
    <x-slot name="header">
        <h2 class="text-black text-3xl font-bold">
            Edit Publisher: {{ $publisher->name }}
        </h2>
    </x-slot>

    <div class="py-12 px-1">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="card bg-gray-300 shadow-xl space-y-6 p-6">

                <form method="POST" action="/publishers/{{ $publisher->id }}" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    @method('PATCH')

                    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                        <label for="name" class="block text-sm font-medium text-gray-900">Name</label>
                        <input type="text" name="name" id="name" class="rounded-lg w-full mt-2"
                               placeholder="Enter book name" value="{{ $publisher->name }}" required>
                        @error('name') <p class="text-xs text-red-500 font-semibold mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                        <label for="logo" class="block text-sm font-medium text-gray-900">Upload New Publisher Logo (max 12MB)</label>
                        <input type="file" name="logo" id="logo" class="rounded-lg w-full mt-2" accept="image/png, image/jpeg" onchange="validateFileSize(this)">

                        <script>
                            function validateFileSize(input) {
                                const file = input.files[0];
                                if (file && file.size > 12 * 1024 * 1024) { // 12MB
                                    alert("File is too large! Maximum allowed size is 12MB.");
                                    input.value = "";
                                }
                            }
                        </script>

                        @error('cover_image')
                        <p class="text-xs text-red-500 font-semibold mt-1">{{ $message }}</p>
                        @enderror
                    </div>


                    <div class="flex flex-col sm:flex-row gap-4 mb-6 text-center justify-between">
                        <x-button href="/publishers/{{ $publisher->id }}" class="btn btn-outline btn-sm">Back</x-button>
                        <x-button type="submit">Save Changes</x-button>
                        <label for="delete-modal" class="items-center px-4 py-2 mx-1 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest
                    hover:bg-red-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-offset-2 cursor-pointer
                    disabled:opacity-50 transition ease-in-out duration-150
                    transform hover:-translate-y-1 hover:shadow-lg active:scale-95">Delete</label>
                    </div>
                </form>

                <form method="POST" action="/publishers/{{ $publisher->id }}" id="delete-form" class="hidden">
                    @csrf
                    @method('DELETE')
                </form>

                <input type="checkbox" id="delete-modal" class="modal-toggle" />
                <div class="modal">
                    <div class="modal-box">
                        <h3 class="font-bold text-lg text-red-600">Confirm Delete</h3>
                        <p class="py-4 text-white">Are you sure you want to delete the publisher <strong>{{ $publisher->name }}</strong>?</p>
                        <div class="modal-action">
                            <label for="delete-modal" class="btn">Cancel</label>
                            <x-button onclick="document.getElementById('delete-form').submit();" class="btn btn-error bg-red-600">Yes, Delete</x-button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
