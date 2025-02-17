<x-guest-layout>
    <x-authentication-card>
        <div class="flex flex-col items-center pt-6 sm:pt-0 m-3">
            <x-slot name="logo">
                <x-authentication-card-logo/>
            </x-slot>

            <div class="w-full sm:max-w-2xl mt-6 p-6 bg-white shadow-md overflow-hidden sm:rounded-lg prose text-black">
                {!! $policy !!}
            </div>
        </div>
    </x-authentication-card>
</x-guest-layout>
