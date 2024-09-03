<!DOCTYPE html>
<html>
<head>
    <title>Client Reset Password</title>
</head>
<body>
    <h2>Client Reset Password</h2>
    @if ($errors->any())
        <div>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form method="POST" action="{{ route('client.password.update') }}">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">
        <div>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
        </div>
        <div>
            <label for="password">New Password:</label>
            <input type="password" id="password" name="password" required>
        </div>
        <button type="submit">Reset Password</button>
    </form>
</body>
</html>
