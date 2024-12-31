<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Otp;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class OtpController extends Controller
{
    public function show()
    {
        // Check if the user is already logged in
        if (Auth::check()) {
            return redirect()->route('home'); // Redirect to the dashboard if logged in
        }

        // If email is already verified, show the login page
        $user = Auth::user();
        if ($user && $user->hasVerifiedEmail()) {
            return view('auth.login'); // Direct them to the login page if verified
        }

        return view('verify_email'); // Show the verify email form if not verified
    }

    public function sendOtp(Request $request)
    {
        $request->validate(['email' => 'required|email']);
        $otp = rand(100000, 999999);

        Otp::updateOrCreate(
            ['email' => $request->email],
            ['otp' => $otp, 'expires_at' => Carbon::now()->addMinutes(5)]
        );

        // Send email
        Mail::raw("Your OTP is $otp", function ($message) use ($request) {
            $message->to($request->email)->subject('OTP Verification');
        });

        return back()->with('message', 'OTP sent to your email.');
    }

    public function verifyOtp(Request $request)
    {
        $request->validate(['email' => 'required|email', 'otp' => 'required']);

        // Find OTP record
        $otpRecord = Otp::where('email', $request->email)->first();

        if ($otpRecord && $otpRecord->otp == $request->otp && $otpRecord->expires_at > Carbon::now()) {
            // Check if the user already exists
            $user = User::where('email', $request->email)->first();

            if (!$user) {
                // Create user with only email, no password set yet
                $user = User::create([
                    'email' => $request->email,
                    // Do not set the password here
                ]);
            }

            // Log in the user after email verification
            //Auth::login($user);

            return redirect()->route('selectOption')->with('message', 'Email verified successfully');
        }

        return back()->withErrors(['otp' => 'Invalid or expired OTP.']);
    }


    public function showPasswordForm()
    {
        return view('setup_password'); // Show the setup password form
    }

    public function setupPassword(Request $request)
    {
        $request->validate([
            'password' => 'required|string|min:8|confirmed', // Ensure password confirmation
        ]);

        // Get the authenticated user (the one that was logged in during email verification)
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login')->withErrors(['error' => 'You must be logged in to set a password.']);
        }

        // Save the hashed password
        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->route('login')->with('message', 'Password set successfully. Please log in.');
    }



}




