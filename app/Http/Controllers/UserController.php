<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Models\OtpVerification;
use Illuminate\Http\RedirectResponse;
use Carbon\Carbon;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Mail;
use App\Mail\OtpMail;


class UserController extends Controller
{
    public function showEmailForm(): View
    {
        return view('auth.email');
    }

    public function sendOtp(Request $request): RedirectResponse
    {
        // Validate the email input
        $request->validate([
            'email' => 'required|email',
        ]);

        // Check if the email already exists in the database
        $email = $request->email;
        // Generate a random 6-digit OTP
        $otp = rand(100000, 999999);

        // Save or update the OTP in the database
        OtpVerification::updateOrCreate(
            ['email' => $email],
            [
                'otp' => $otp,
                'expires_at' => now()->addMinutes(5)
            ]
        );

        // Send email using built-in Mail facade (we’ll customize this later)
        Mail::to($email)->send(new OtpMail($otp));

        // Store the email in session to show the next form
        return redirect()->route('auth.otp')->with('success', 'OTP sent to your email');
    }

    // Show the OTP form 
    public function showOtpForm()
    {
        return view('auth.otp');
    }

    // Verify the OTP
    public function verifyOtp(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => 'required|email',
            'otp' => 'required|digits:6'
        ]);

        // Fetching the first record from the database
        $verification = OtpVerification::where('email', $request->email)->first();

        // Check if the Email does exist
        if (!$verification) {
            return back()->with('error', 'Email not found.');
        }

        // check if the expires_at field is null
        if (!$verification->expires_at || Carbon::now()->gt($verification->expires_at)) {
            return back()->with('error', 'OTP has expired. Please request a new one.');
        }

        // Check if the OTP matches which was entered matches with the one in the database
        if ($verification->otp !== $request->otp) {
            return back()->with('error', 'Invalid OTP. Please try again.');
        }

        // Success: OTP matches and is not expired
        session(['verified_email' => $request->email]);
        return redirect()->route('register')->with('success', 'OTP verified! You may now register.');

    }

    // Show the registration form only if the email is verified
    public function showRegisterForm()
    {
        if (!session()->has('verified_email')) {
            return redirect()->route('auth.email')->with('error', 'Please verify your email before registering.');
        }

        return view('auth.register');
    }


}
