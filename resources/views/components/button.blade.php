@props(['href' => null, 'type' => 'submit'])

@php
    $baseClasses = 'items-center px-4 py-2 bg-gray-800 mx-1 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest
                    hover:bg-gray-700 hover:shadow-lg focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2
                    disabled:opacity-50 transition ease-in-out duration-150
                    transform hover:-translate-y-1 active:scale-95 text-center';
@endphp

@if($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $baseClasses]) }}>
        {{ $slot }}
    </a>
@else
    <button {{ $attributes->merge(['type' => $type, 'class' => $baseClasses]) }}>
        {{ $slot }}
    </button>
@endif
