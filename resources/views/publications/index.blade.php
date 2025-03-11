<!-- resources/views/publications/index.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Publications</title>
</head>
<body>
    <h1>Top Publications</h1>
    <ul>
        @foreach ($publications as $publication)
            <li>{{ strtoupper(substr($publication->title, 0, 3)) }} - {{ $publication->title }}</li>
        @endforeach
    </ul>
</body>
</html>
