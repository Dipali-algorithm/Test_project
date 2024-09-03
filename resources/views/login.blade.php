<!-- resources/views/admin/login.blade.php -->
@extends('layout')

@section('title', 'Admin Login')

@section('content')
    <div class="container">
        <h2>Login Form</h2>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form action="{{ route('admin.login.submit') }}" method="post">
            @csrf
            <div>
                <label for="user_name">Username</label>
                <input type="text" name="user_name" placeholder="Username" required>
            </div>
            <div>
                <label for="password">Password</label>
                <input type="password" name="password" placeholder="Password" required>
            </div>
            <div>
                <button type="submit">Login</button>
            </div>
        </form>
        <div>
            <a href="{{ route('admin.password.request') }}">Forgot Your Password?</a>
            <a href="{{ route('admin.register') }}">Register</a>
        </div>
    </div>
@endsection
