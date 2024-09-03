<!-- resources/views/submitted.blade.php -->

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submitted Data</title>
</head>

<body>
    <h1>Submitted Data</h1>

    @if ($data)
        Name: {{ $data['name'] }}</p>
        Email: {{ $data['email'] }}</p>
    @else
        <p>No data submitted.</p>
    @endif


</body>

</html>
