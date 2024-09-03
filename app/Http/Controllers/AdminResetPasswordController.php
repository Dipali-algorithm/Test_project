<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\Admin;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Log;


class AdminResetPasswordController extends Controller
{
    public function showResetForm(Request $request, $token = null)
    {
        return view('reset')->with([
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

        $admin = Admin::where('email', $request->email)->first();

        if (!$admin) {
            Log::info('Admin not found', ['email' => $request->email]);
            return back()->withErrors(['email' => 'Admin not found.']);
        }

        //exit($request->remember_token . ' || ' . $admin->remember_token);
        // if ($request->token != $admin->remember_token) {
        //     // if (!Hash::check($request->token, $admin->remember_token)) {
        //     return back()->withErrors(['token' => 'The provided token is incorrect.']);
        // }

        $hashedPassword = Hash::make($request->password);
        $admin->password = $hashedPassword;
        $admin->remember_token = Str::random(60);
        $admin->save();

        return redirect()->route('admin.login')->with('status', 'Password has been reset successfully.');
    }
}
