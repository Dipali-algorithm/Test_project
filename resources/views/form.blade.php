<!-- resources/views/form.blade.php -->

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Example</title>
</head>

<body>
    <h1>Simple Form</h1>

    <form action="{{ route('form.handle') }}?_token={{ csrf_token() }}" method="post">

        <label for="name">Name:</label>
        <input type="text" id="name" name="name" value="{{ old('name') }}" required>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="{{ old('email') }}" required>

        <input type="submit" value="Submit">
    </form>
</body>

</html>
