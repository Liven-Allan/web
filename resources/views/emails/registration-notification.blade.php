<!DOCTYPE html>
<html>
<head>
    <title>Welcome to The BigDataLab System</title>
    <style>
        .button {
            background-color: #4CAF50; /* Green */
            border: none;
            color: white;
            padding: 15px 32px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin: 4px 2px;
            cursor: pointer;
            border-radius: 12px;
        }
    </style>
</head>
<body>

    <h1>Hello, {{ $emailData['name'] }}</h1>
    <p>You have been successfully registered into the system by {{ $emailData['registered_by'] }}.</p>
    <p>Your email: {{ $emailData['email'] }}</p>
    <p>Your password: {{ $emailData['password'] }}</p>
    <p>Click the link below to go to the website page:</p>

    <!-- Button that links to the website -->
    <a href="http://bdal.tech" class="button">Go to Website</a>

    <p>Please log in to your account to get started using the above credentials.</p>
    <p>Thank you!</p>

</body>
</html>
