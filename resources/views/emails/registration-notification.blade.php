<!DOCTYPE html>
<html>
<head>
    <title>Welcome to The BigDataLab System</title>
</head>
<body>

    <h1>Hello, {{ $emailData['name'] }}</h1>
    <p>You have been successfully registered into the system by {{ $emailData['registered_by'] }}.</p>
    <p>Your email: {{ $emailData['email'] }}</p>
    <p>Your password: {{ $emailData['password'] }}</p>
    <p>Please log in to your account to get started using the above credentials.</p>
    <p>Thank you!</p>

</body>
</html>
