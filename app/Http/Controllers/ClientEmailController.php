<?php

namespace App\Http\Controllers;

use App\Mail\clientwelcomeemail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ClientEmailController extends Controller
{
    public function sendEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $toEmail = $request->email;
        $token = Str::random(60);
        $message = "Hello, welcome to our website. Please reset your password using the link below.";
        $subject = "Password Reset Request";

        Log::info('Email: ' . $toEmail . ', Token: ' . $token);

        // Save the token to your database with the email
        DB::table('clients')->updateOrInsert(
            ['email' => $toEmail], // Condition to check
            [
                'verify_token' => $token,
                'updated_at' => now()
            ]
        );


        Mail::to($toEmail)->send(new clientwelcomeemail($message, $subject, $token, $toEmail));

        return back()->with('message', 'Password reset email sent!');
    }
}
