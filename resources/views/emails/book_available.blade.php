<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Your Book is Now Available</title>
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
        <h2>Your Book is Now Available!</h2>
    </div>

    <div class="content">
        <p><strong>Book Title:</strong> {{ $bookTitle }}</p>
        <p>Good news! The book you're interested in is now available at the library.</p>
        <p>
            <a href="{{ $bookLink }}" class="button">Request Now</a>
        </p>
    </div>

    <div class="footer">
        <p>&copy; {{ date('Y') }} Inovcorp Library</p>
    </div>
</div>

</body>
</html>
