<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Book Due Reminder</title>
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
        .header {
            background-color: #374151;
            color: white;
            padding: 10px;
            border-radius: 8px 8px 0 0;
            text-align: center;
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
        .cover-image {
            max-width: 150px;
            margin: 10px auto;
            display: block;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
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
        <h2>Book Due Reminder</h2>
    </div>

    <p>Hello {{ $userName }},</p>
    <p>This is a friendly reminder that the following book is due for return tomorrow. Please ensure it is returned on time to avoid any penalties.</p>

    <table class="table">
        <tr>
            <th>Book Title</th>
            <td>{{ $bookRequest->book->name }}</td>
        </tr>
        <tr>
            <th>ISBN</th>
            <td>{{ $bookRequest->book->isbn }}</td>
        </tr>
        <tr>
            <th>Due Date</th>
            <td>{{ $bookRequest->due_date }}</td>
        </tr>
    </table>

    <div style="text-align: center; margin: 20px 0;">
        <p><strong>Book Cover:</strong></p>
        <img src="{{ $bookRequest->book->cover_image }}" alt="Book Cover" class="cover-image">
    </div>

    <p>Thank you for using our library services. We look forward to seeing you soon!</p>

    <div class="footer">
        <p>&copy; {{ date('Y') }} Library Management System</p>
    </div>
</div>

</body>
</html>
