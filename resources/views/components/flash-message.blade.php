@if($message)
    @php
        $colors = [
            'success' => 'bg-green-500',
            'error' => 'bg-red-500',
            'warning' => 'bg-yellow-500',
            'info' => 'bg-blue-500'
        ];
        $bgColor = $colors[$type] ?? 'bg-gray-500';
    @endphp

    <div class="{{ $bgColor }} text-white text-center p-3 rounded-lg my-2 flash-message mx-3">
        {{ $message }}
    </div>

    <script>
        setTimeout(function () {
            let flashMessage = document.querySelector('.flash-message');
            if (flashMessage) {
                flashMessage.style.transition = "opacity 0.5s";
                flashMessage.style.opacity = "0";
                setTimeout(() => flashMessage.remove(), 500);
            }
        }, 3000);
    </script>
@endif
