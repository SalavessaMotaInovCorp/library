<x-app-layout>
    <x-slot name="header">
        <h2 class="text-black text-3xl font-bold text-center">
            Register a new author
        </h2>
    </x-slot>

    <div class="py-12 px-1">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="card bg-gray-300 shadow-xl space-y-6 p-6">

                <form method="POST" action="/authors" enctype="multipart/form-data" class="space-y-6">
                    @csrf

                    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                        <label for="title" class="block text-sm font-medium text-gray-900">Name</label>
                        <input
                            type="text"
                            name="name"
                            id="name"
                            class="rounded-lg w-full mt-2"
                            placeholder="Enter author name"
                            required>
                        @error('name')
                        <p class="text-xs text-red-500 font-semibold mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                        <label for="photo" class="block text-sm font-medium text-gray-900">Author photo (max 12MB)</label>
                        <input type="file" name="photo" id="photo" class="rounded-lg w-full mt-2" accept="image/png, image/jpeg" required onchange="validateFileSize(this)">

                        <script>
                            function validateFileSize(input) {
                                const file = input.files[0];
                                if (file && file.size > 12 * 1024 * 1024) {
                                    alert("File is too large! Maximum allowed size is 12MB.");
                                    input.value = "";
                                }
                            }
                        </script>

                        @error('photo')
                        <p class="text-xs text-red-500 font-semibold mt-1">{{ $message }}</p>
                        @enderror
                    </div>



                    <div class="flex justify-between items-center mt-6">
                        <x-button href="/authors">Back</x-button>

                        <div class="flex gap-4">
                            <x-button type="submit">Save</x-button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
