<!DOCTYPE html>
<html>

<head>
    <title>Client Password Reset</title>
</head>

<body>
    <h2>Hello</h2>
    <p>You are receiving this email because we received a password reset request for your account.</p>
    <a href="{{ url('client/password/reset', $token) }}">Click here to reset your password</a>
    <h3>{{ $subject }}</h3>
    <p>{{ $mailmessage }}</p>

    <!-- <p>If you did not request a password reset, no further action is required.</p> -->
</body>

</html>
