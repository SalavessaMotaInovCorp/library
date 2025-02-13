<x-app-layout>
    <div class="mx-auto w-1/2">
        <form class="p-12 text-center" id="register-admin-form" method="POST" action="{{ route('store_admin') }}">
            @csrf

            <h1 class="text-center text-4xl font-bold text-black mb-3">Register a new Admin</h1>

            <div>
                <x-label for="name" value="{{ __('Name') }}" />
                <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            </div>

            <div class="mt-4">
                <x-label for="email" value="{{ __('Email') }}" />
                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            </div>

            <div class="mt-4">
                <x-label for="password" value="{{ __('Password') }}" />
                <x-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
            </div>

            <div class="mt-4">
                <x-label for="password_confirmation" value="{{ __('Confirm Password') }}" />
                <x-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
            </div>

            <div class="flex justify-between mt-6">
                @auth
                    <x-button href="{{ route('dashboard') }}">Home</x-button>
                @else
                    <x-button href="/">Home</x-button>
                @endauth

                <label for="confirm-register-modal" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest
                    hover:bg-gray-700 hover:shadow-lg focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2
                    disabled:opacity-50 transition ease-in-out duration-150
                    transform hover:-translate-y-1 active:scale-95">
                    Register Admin
                </label>
            </div>

            <input type="checkbox" id="confirm-register-modal" class="modal-toggle" />

            <div class="modal">
                <div class="modal-box text-white text-center">
                    <h2 class="font-bold text-2xl mb-4">Confirm Registration</h2>
                    <p>Are you sure you want to create this new admin?</p>

                    <div class="modal-action justify-center mt-6">
                        <label for="confirm-register-modal" class="btn bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Cancel</label>

                        <x-button type="submit">
                            Yes, Confirm
                        </x-button>
                    </div>
                </div>
            </div>
        </form>
    </div>

</x-app-layout>
