<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ForgotPasswordController extends Controller
{
    public function showLinkRequestForm()
    {
        return view('auth.forgot-password');
    }

    public function verifyEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $user = User::where('email', $request->email)->first();

        if (!$user instanceof User) {
            return back()->with('error_sweetalert', 'Email tidak terdaftar pada sistem!');
        }

        // Store email in session to be used in the reset form
        $request->session()->put('reset_email', $request->email);

        return redirect()->route('password.reset.custom');
    }

    public function showResetForm(Request $request)
    {
        if (!$request->session()->has('reset_email')) {
            return redirect()->route('password.request');
        }

        return view('auth.reset-password-custom');
    }

    public function reset(Request $request)
    {
        $request->validate([
            'password' => 'required|string|min:8|confirmed',
        ]);

        $email = $request->session()->get('reset_email');
        if (!$email) {
            return redirect()->route('password.request');
        }

        $user = User::where('email', $email)->first();
        if (!$user instanceof User) {
            return redirect()->route('password.request');
        }

        $user->password = Hash::make($request->password);
        $user->save();

        $request->session()->forget('reset_email');

        return redirect()->route('login')->with('success', 'Password berhasil diubah. Silakan login dengan password baru Anda.');
    }
}
