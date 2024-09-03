<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use App\Models\Client;

class ClientForgotPasswordController extends Controller
{
    public function client_showLinkRequestForm()
    {
        return view('client_forgot'); // Assuming your view is in resources/views/admin/forgot.blade.php
    }

    // Send password reset email
    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        // Custom Password Broker for 'clients' guard
        $status = Password::broker('clients')->sendResetLink(
            $request->only('email')
        );

        // Redirect back with status message
        return back()->with('status', __($status));
    }
}
