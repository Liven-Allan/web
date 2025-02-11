<!DOCTYPE html>
<html>
<head>
    <title>Welcome to The BigDataLab System</title>
</head>
<body>

    {{-- Debugging Output --}}
    <pre>{{ print_r($emailData, true) }}</pre> 

    <h1>Hello, {{ $emailData['name'] }}</h1>
    <p>You have been successfully registered into the system by {{ $emailData['registered_by'] }}.</p>
    <p>Your email: {{ $emailData['email'] }}</p>
    <p>Your password: {{ $emailData['password'] }}</p>
    <p>Please log in to your account to get started.</p>
    <p>Thank you!</p>

</body>
</html>
