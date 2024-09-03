@extends('layout')

@section('title', 'forgot Password')

@section('content')
    <div id="menu"></div>
    <div id="main-content">
        <h2>Admin Forgot Password</h2>
        <form method="POST" action="{{ route('admin.password.email') }}">
            @csrf
            <div>
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>
            <button type="submit">Send Password Reset Link</button>

        </form>
    @endsection
