<!-- resources/views/admin/login.blade.php -->
@extends('layout')

@section('title', 'client Login')

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
        <form action="{{ route('client.login.submit') }}" method="post">
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
            <a href="{{ route('client.password.request') }}">Forgot Your Password?</a>
            <a href="{{ route('client.register') }}">Register</a>
        </div>
    </div>
@endsection
