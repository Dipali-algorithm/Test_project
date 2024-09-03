<!-- resources/views/admin/register.blade.php -->
@extends('layout')

@section('title', 'Client Register')

@section('content')
    <div class="container">
        <h2>Register Form</h2>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form action="{{ route('client.register.submit') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div>
                <label for="first_name">First Name</label>
                <input type="text" name="first_name" value="{{ old('first_name') }}" placeholder="First Name" required>
            </div>
            <div>
                <label for="last_name">Last Name</label>
                <input type="text" name="last_name" value="{{ old('last_name') }}" placeholder="Last Name" required>
            </div>
            <div>
                <label for="user_name">Username</label>
                <input type="text" name="user_name" value="{{ old('user_name') }}" placeholder="Username" required>
            </div>
            <div>
                <label for="email">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" placeholder="Email" required>
            </div>
            <div>
                <label for="password">Password</label>
                <input type="password" name="password" placeholder="Password" required>
            </div>
            <div>
                <label for="user_image">User Image</label>
                <input type="file" name="image" accept=".jpg,.jpeg,.png">
            </div>
            <div>
                <button type="submit">Register</button>
            </div>
        </form>
        <div>
            <a href="{{ route('client.login') }}">Login</a>
            <a href="{{ route('client.password.request') }}">Forgot Password?</a>
        </div>
    </div>
@endsection
