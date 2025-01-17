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
                    'password' => null,
                ]);
            }

            session(['user_id' => $user->id]);

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
            'password' => 'required|string|min:4|confirmed', // Ensure password confirmation
        ]);

        // Get the authenticated user (the one that was logged in during email verification)
        //$user = Auth::user();
        $userId = session('user_id');

        if (!$userId) {
            return redirect()->route('login')->withErrors(['error' => 'Session expired. Please try again.']);
        }

        $user = User::find($userId);

        if (!$user) {
            return redirect()->route('login')->withErrors(['error' => 'User not found.']);
        }


        // Save the hashed password
        $user->password = Hash::make($request->password);

        if ($user->save()) {
            return redirect()->route('login')->with('message', 'Password set successfully. Please log in.');
        }

        return back()->withErrors(['error' => 'Failed to save password.']);
    }
}
