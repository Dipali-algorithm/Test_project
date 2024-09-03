<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use App\Models\Admin;

class AdminForgotPasswordController extends Controller
{
    public function showLinkRequestForm()
    {
        return view('forgot'); // Assuming your view is in resources/views/admin/forgot.blade.php
    }

    // Send password reset email
    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $status = Password::broker('admins')->sendResetLink(
            $request->only('email')
        );

        // Redirect back with status message
        return back()->with('status', __($status));
    }
}
