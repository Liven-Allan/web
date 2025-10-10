<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Your Email</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            margin: 0;
            padding: 20px;
            background-color: #f4f4f4;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .button {
            display: inline-block;
            padding: 10px 20px;
            color: #fff;
            background-color: #007bff;
            text-decoration: none;
            border-radius: 5px;
        }
        .button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <p>Hello {{ $emailData['name'] }},</p>
        <p>An account has been created for you by {{ $emailData['registered_by'] }}.</p>
        <p>Your email: {{ $emailData['email'] }}</p>
        <p>To verify your email and set your password, click the button below:</p>
        <a href="{{ $emailData['url'] ?? '#' }}" class="button">Verify Email Address</a>
        <p>If the button doesn’t work, copy and paste this URL into your browser:</p>
        <p>{{ $emailData['url'] ?? '' }}</p>
        <p>If you did not expect this, ignore this email.</p>
    </div>
</body>
</html>