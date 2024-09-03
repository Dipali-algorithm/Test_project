<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;



class ClientAuthController extends Controller
{
    public function client_showLoginForm()
    {
        return view('client_login');
    }

    public function client_login(Request $request)
    {
        $credentials = $request->validate([
            'user_name' => 'required|string',
            'password' => 'required|string',
        ]);

        if (Auth::guard('client')->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('home');
        }

        return back()->withErrors([
            'user_name' => 'Invalid credentials',
        ]);
    }

    public function client_logout(Request $request)
    {
        Auth::guard('client')->logout();
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('client.login.submit');
    }

    public function client_showRegistrationForm()
    {
        return view('client_register');
    }

    public function client_register(Request $request)
    {
        $data = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'user_name' => 'required|string|max:255|unique:clients,user_name',
            'email' => 'required|string|email|max:255|unique:clients,email',
            'password' => 'required|string|min:8',
            'image' => 'required|image',
        ]);
        $imagePath = $request->file('image')->store('images', 'public');
        $client = Client::create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'user_name' => $data['user_name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'image' => $imagePath,
        ]);

        Auth::guard('client')->login($client);


        return redirect()->route('home');
    }
}
