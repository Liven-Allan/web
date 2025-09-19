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
        <p>Hello {{ $name }},</p>
        <p>An account has been created for you by {{ $registered_by }}.</p>
        <p>Your email: {{ $email }}</p>
        <p>Please click the button below to verify your email address. You will then be prompted to set your password.</p>
        <a href="{{ $url }}" class="button">Verify Email Address</a>
        <p>This link will expire in {{ config('auth.verification.expire', 60) }} minutes.</p>
        <p>If you did not create an account, no further action is required.</p>
    </div>
</body>
</html>