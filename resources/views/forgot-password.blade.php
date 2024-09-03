<!DOCTYPE html>
<html>

<head>
    <title>Forgot Password</title>
</head>

<body>
    <h2>Forgot Password</h2>
    @if (session('status'))
        <div>
            {{ session('status') }}
        </div>
    @endif
    @if ($errors->any())
        <div>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form method="POST" action="{{ route('client.password.email') }}">
        @csrf
        <div>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
        </div>
        <button type="submit">Send Password Reset Link</button>
    </form>
</body>

</html>
