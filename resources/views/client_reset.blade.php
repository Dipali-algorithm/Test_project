<!DOCTYPE html>
<html>

<head>
    <title>Admin Reset Password</title>
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
    <form action="{{ route('client.password.update') }}" method="POST">
        @csrf
        <input type="hidden" name="verify_token" value="{{ $token }}">
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <!-- <div class="form-group">
            <label for="password_confirmation">Confirm Password</label>
            <input type="password" name="password_confirmation" class="form-control" required>
        </div> -->
        <button type="submit" class="btn btn-primary">Reset Password</button>
    </form>
    </div>
