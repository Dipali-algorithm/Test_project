<!DOCTYPE html>
<html>

<head>
    <title>Admin Reset Password</title>
</head>

<body>
    <h2>Admin Reset Password</h2>
    @if ($errors->any())
        <div>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form method="POST" action="{{ route('admin.password.update') }}">

        @csrf
        <input type="hidden" name="remember_token" value="{{ $token }}">
        <div>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
        </div>
        <div>
            <label for="password">New Password:</label>
            <input type="password" id="password" name="password" required>
        </div>
        <!-- <div>
            <label for="password_confirmation">Confirm Password:</label>
            <input type="password" id="password_confirmation" name="password_confirmation" required>
        </div> -->
        <button type="submit">Reset Password</button>
    </form>

</body>

</html>
