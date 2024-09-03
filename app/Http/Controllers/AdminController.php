<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;

class AdminController extends Controller
{
    public function showLoginForm()
    {
        return view('login'); // Adjust to your view path
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'user_name' => 'required|string',
            'password' => 'required|string',
        ]);

        if (Auth::guard('admin')->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/'); // Redirect to admin dashboard or another page after login
        }

        return back()->withErrors([
            'user_name' => 'Invalid credentials',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('admin.login'); // Redirect to admin login page after logout
    }

    public function showRegistrationForm()
    {
        return view('register'); // Adjust to your view path
    }

    public function register(Request $request)
    {
        // Your registration logic goes here
    }
}
