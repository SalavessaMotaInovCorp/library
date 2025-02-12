<x-app-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot>

        <x-validation-errors class="mb-4" />

        <form id="register-admin-form" method="POST" action="{{ route('store_admin') }}">
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

                <label for="confirm-register-modal" class="btn bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 cursor-pointer">
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
    </x-authentication-card>
</x-app-layout>
