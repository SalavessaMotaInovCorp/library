<x-app-layout>
    <x-slot name="header">
        <h2 class="text-black text-3xl font-bold">
            Your shopping cart
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">


                @if($notifications->isNotEmpty())
                    @foreach($notifications as $notification)
                        <div x-data="{ show: true }" x-show="show" class="bg-red-600 text-white text-center p-3 rounded-lg mb-4 mx-6 flex justify-between items-center">
                            <span>{{ $notification->message }}</span>
                            <button @click="show = false" class="ml-4 bg-white text-red-600 px-2 py-1 rounded-full hover:bg-gray-200">
                                &times;
                            </button>
                        </div>
                    @endforeach
                @endif


            @if ($cartItems->isEmpty())
                    <div class="text-center">
                        <p class="text-gray-600">Your shopping cart is empty!</p>
                    </div>
                @else
                    <div class="overflow-x-auto p-6 mb-1">
                        <x-flash-message type="success"/>
                        <table class="table w-full text-black">
                            <thead>
                            <tr class="bg-gray-200 text-black text-center font-bold">
                                <th class="border border-gray-300 p-2">Book</th>
                                <th class="border border-gray-300 p-2">Subtotal</th>
                                <th class="border border-gray-300 p-2">Remove book</th>
                            </tr>
                            </thead>
                            <tbody>
                            @php
                                $total = 0;
                            @endphp
                            @foreach ($cartItems as $cartItem)
                                @php
                                    $total += $cartItem->book->price;
                                @endphp
                                <tr class="hover:bg-gray-100">
                                    <td class="border border-gray-300 p-2">{{ $cartItem->book->name }}</td>
                                    <td class="border border-gray-300 p-2 text-center">{{ $cartItem->book->price }} €</td>
                                    <td class="border border-gray-300 p-2">
                                        <div class="text-center">
                                            <form method="POST" action="{{ route('cart.remove', ['id' => $cartItem->id]) }}">
                                                @csrf
                                                @method('DELETE')
                                                <x-button type="submit" class="mt-1 border-0">{!! '<i class="fa-solid fa-minus"></i>' !!}</x-button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>

                        <div class="flex justify-between items-center mt-6 p-6">
                            <div class="text-lg font-semibold">
                                <p>TOTAL: <span class="text-blue-700">{{ number_format($total, 2) }} €</span></p>
                            </div>
                            <form action="{{ route('orders.create') }}" method="POST">
                                @csrf
                                <x-button class="mt-1 bg-green-600 hover:bg-green-700 text-white px-4 py-2">
                                    Make Order
                                </x-button>
                            </form>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>

{{--<script>--}}
{{--    setTimeout(function () {--}}
{{--        let flashMessage = document.querySelector('.bg-green-500, .bg-red-500');--}}
{{--        if (flashMessage) {--}}
{{--            flashMessage.style.transition = "opacity 0.5s";--}}
{{--            flashMessage.style.opacity = "0";--}}
{{--            setTimeout(() => flashMessage.remove(), 500);--}}
{{--        }--}}
{{--    }, 3000);--}}
{{--</script>--}}
