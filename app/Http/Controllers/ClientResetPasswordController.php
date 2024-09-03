<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\Client;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Log;


class ClientResetPasswordController extends Controller
{
    public function client_showResetForm(Request $request, $token = null)
    {
        return view('client_reset')->with([
            'token' => $token,
            'email' => $request->email
        ]);
    }

    public function reset(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => ['required', Rules\Password::defaults()]
        ]);

        $client = Client::where('email', $request->email)->first();

        if (!$client) {
            Log::info('Client not found', ['email' => $request->email]);
            return back()->withErrors(['email' => 'Client not found.']);
        }

        // exit($request->remember_token . ' || ' . $admin->remember_token);
        // if ($request->token != $admin->remember_token) {
        //     // if (!Hash::check($request->token, $admin->remember_token)) {
        //     return back()->withErrors(['token' => 'The provided token is incorrect.']);
        // }

        $hashedPassword = Hash::make($request->password);
        $client->password = $hashedPassword;
        $client->verify_token = Str::random(60);
        $client->save();

        return redirect()->route('client.login')->with('status', 'Password has been reset successfully.');
    }
}
