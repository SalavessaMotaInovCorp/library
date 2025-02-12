<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Book Request Notification</title>
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
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        .table {
            width: 100%;
            border-collapse: collapse;
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
        .header {
            background-color: #374151;
            color: white;
            padding: 10px;
            border-radius: 8px 8px 0 0;
            text-align: center;
        }
        .cover-image {
            max-width: 150px;
            margin: 10px auto;
            display: block;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>

<div class="container">
    <div class="header">
        <h2>{{ $isUser ? 'Your Book Request is Confirmed!' : 'New Book Request Submitted' }}</h2>
    </div>

    <table class="table">
        <tr>
            <th>Book Title</th>
            <td>{{ $book->name }}</td>
        </tr>
        <tr>
            <th>ISBN</th>
            <td>{{ $book->isbn }}</td>
        </tr>
        <tr>
            <th>Request Date</th>
            <td>{{ $bookRequest->request_date }}</td>
        </tr>
        <tr>
            <th>Due Date</th>
            <td>{{ $bookRequest->due_date }}</td>
        </tr>
        @if(!$isUser)
            <tr>
                <th>Requested By</th>
                <td>{{ $bookRequest->user->name }}</td>
            </tr>
            <tr>
                <th>User Email</th>
                <td>{{ $bookRequest->user->email }}</td>
            </tr>
        @endif
    </table>

    <div style="text-align: center; margin: 20px 0;">
        <p><strong>Book Cover:</strong></p>
        <img src="{{ $book->cover_image }}" alt="Book Cover" class="cover-image">
    </div>

    <div style="text-align: center; padding: 10px;">
        @if($isUser)
            <p>Thank you for your request! You will be notified when the book is ready for return.</p>
        @else
            <p>A new book request has been made. Please review it in the system.</p>
        @endif
    </div>
</div>

</body>
</html>
