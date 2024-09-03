<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Password Reset</title>
</head>

<body>
    <h2>Hello</h2>
    <p>You are receiving this email because we received a password reset request for your account.</p>
    <a href="{{ url('admin/password/reset', $token) }}">Click here to reset your password</a>

    <h3>{{ $subject }}</h3>
    <p>{{ $mailmessage }}</p>
</body>

</html>
