<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Book Review Submitted</title>
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
            padding: 15px;
            border-radius: 8px 8px 0 0;
            text-align: center;
            font-size: 20px;
            font-weight: bold;
        }

        .content {
            padding: 20px;
            line-height: 1.6;
            color: #333;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        .table th, .table td {
            border: 1px solid #e5e7eb;
            padding: 12px;
            text-align: left;
        }

        .table th {
            background-color: #e5e7eb;
            color: #111827;
        }

        .table tr:nth-child(even) {
            background-color: #f9fafb;
        }

        .button {
            display: inline-block;
            padding: 12px 20px;
            margin-top: 20px;
            background-color: #374151;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            text-align: center;
        }

        .button:hover {
            background-color: #0056b3;
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
        New Book Review Submitted
    </div>

    <div class="content">
        <p>Hello Admin,</p>
        <p>A new book review has been submitted by <strong>{{ $reviewer }}</strong>. Below are the details:</p>

        <table class="table">
            <tr>
                <th>Book Title</th>
                <td>{{ $bookTitle }}</td>
            </tr>
            <tr>
                <th>Rating</th>
                <td>⭐ {{ $rating }}/5</td>
            </tr>
            <tr>
                <th>Comment</th>
                <td>"{{ $comment }}"</td>
            </tr>
        </table>

        <p>You can review and manage this submission by clicking the button below:</p>

        <p style="text-align: center;">
            <a href="{{ $reviewLink }}" class="button">Review Submission</a>
        </p>

        <p>Thank you for keeping our library's reviews well-managed!</p>
    </div>

    <div class="footer">
        <p>&copy; {{ date('Y') }} Inovcorp Library</p>
    </div>
</div>

</body>
</html>
