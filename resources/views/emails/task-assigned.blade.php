<!DOCTYPE html>
<html>
<head>
    <title>New Task Assigned</title>
</head>
<body>

    <h2>Hello, {{ $emailData['name'] }}</h2>
    <p>You have been assigned a new task.</p>

    <p><strong>Task Title:</strong> {{ $emailData['task_title'] }}</p>
    <p><strong>Description:</strong> {{ $emailData['task_description'] }}</p>
    <p><strong>Priority:</strong> {{ $emailData['priority'] }}</p>
    <p><strong>Due Date:</strong> {{ $emailData['due_date'] }}</p>
    <p><strong>Assigned By:</strong> {{ $emailData['assigned_by'] }}</p>

    <p>Please log in to your account to review and start working on the task.</p>

    <p>Thank you!</p>

</body>
</html>
