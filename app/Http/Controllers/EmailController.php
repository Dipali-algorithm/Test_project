<?php

namespace App\Http\Controllers;

use App\Mail\welcomeemail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class EmailController extends Controller
{
    public function sendEmail(Request $request)
    {
        $toEmail = $request->email;
        $token = Str::random(60);
        $message = "Hello, welcome to our website. Please reset your password using the link below.";
        $subject = "Password Reset Request";

        // Save the token to your database with the email
        DB::table('admins')->updateOrInsert(
            ['email' => $toEmail], // Condition to check
            [
                'remember_token' => $token,
                'updated_at' => now()
            ]
        );

        Mail::to($toEmail)->send(new welcomeemail($message, $subject, $token, $toEmail));

        return back()->with('message', 'Password reset email sent!');
    }
}
