<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Need help with your books?</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
        }

        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            max-width: 600px;
            margin: auto;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .header {
            background-color: #374151;
            color: white;
            padding: 10px;
            border-radius: 8px 8px 0 0;
            text-align: center;
        }

        .content {
            padding: 20px;
            text-align: center;
        }

        .button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #374151;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 20px;
        }

        .footer {
            text-align: center;
            color: #6b7280;
            font-size: 12px;
            margin-top: 20px;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="header">
        <h2>Need help with your books?</h2>
    </div>

    <div class="content">
        <p>Hi {{ $user->name }},</p>
        <p>We noticed that you added the following books to your cart but haven't completed your purchase yet.</p>

        <ul style="text-align: left;">
            @foreach($cartItems as $item)
                <li><strong>{{ $item->book->name }}</strong></li>
            @endforeach
        </ul>

        <p>Do you need any help? Click below to return to your cart and complete your order.</p>

        <a href="{{ $cartUrl }}" class="button">Go to Cart</a>
    </div>

    <div class="footer">
        <p>&copy; {{ date('Y') }} Inovcorp Library</p>
    </div>
</div>

</body>
</html>
