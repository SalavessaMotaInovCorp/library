<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Review Status Update</title>
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
        }

        .footer {
            text-align: center;
            color: #6b7280;
            font-size: 12px;
            margin-top: 20px;
        }

        .button {
            display: inline-block;
            padding: 10px 20px;
            background: #374151;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
        }

        .justification {
            background: #ffe4e1;
            padding: 10px;
            border-left: 4px solid #dc3545;
            margin-top: 15px;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="header">
        <h2>Book Review Status Update</h2>
    </div>

    <div class="content">
        <p>Hello,</p>

        <p>Your review for the book <strong>{{ $bookTitle }}</strong> has been <strong>{{ $status }}</strong>.</p>

        @if($status === 'refused' && $justification)
            <div class="justification">
                <strong>Justification:</strong>
                <p>{{ $justification }}</p>
            </div>

            <p>You can check your review details below:</p>
            <p><a href="{{ $reviewLink }}" class="button">View Review</a></p>
        @endif


        <p>Thank you for using our library services!</p>
    </div>

    <div class="footer">
        <p>&copy; {{ date('Y') }} Inovcorp Library</p>
    </div>
</div>

</body>
</html>
