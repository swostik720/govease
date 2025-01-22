<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Otp;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Str;

class OtpController extends Controller
{
    public function show()
    {
        if (Auth::check()) {
            return response()->json([
                'message' => 'User is already logged in.',
                'redirect' => route('home'),
            ], 200);
        }

        return response()->json([
            'message' => 'Please verify your email to proceed.'
        ], 200);
    }

    public function sendOtp(Request $request)
    {
        $request->validate(['email' => 'required|email']);
        $otp = rand(100000, 999999);

        Otp::updateOrCreate(
            ['email' => $request->email],
            ['otp' => $otp, 'expires_at' => Carbon::now()->addMinutes(5)]
        );

        Mail::raw("Your OTP is $otp", function ($message) use ($request) {
            $message->to($request->email)->subject('OTP Verification');
        });

        return response()->json([
            'message' => 'OTP sent successfully to your email.',
            'redirect' => url('/api/verify-otp'),
        ], 200);
    }

    public function verifyOtp(Request $request)
    {
        $request->validate(['email' => 'required|email', 'otp' => 'required']);

        $otpRecord = Otp::where('email', $request->email)->first();

        if ($otpRecord && $otpRecord->otp == $request->otp && $otpRecord->expires_at > Carbon::now()) {
            $user = User::firstOrCreate(['email' => $request->email]);
            // Generate a unique token and save it (you can store this token in the database if needed)
            $token = Str::random(60);  // Generates a 60-character random string

            // Optionally save the token in the database or cache it for future validation
            $user->token = $token;
            $user->save(); // Save the token to the user (or store it somewhere secure)


            return response()->json([
                'message' => 'Email verified successfully.',
                'token' => $token,
                'redirect' => url('/api/select-option'),
            ], 200);
        }

        return response()->json(['error' => 'Invalid or expired OTP.'], 400);
    }

    public function showPasswordForm()
    {
        return response()->json([
            'message' => 'Please set up your password to continue.',
            'redirect' => route('setup-password')
        ]);
    }

    public function setupPassword(Request $request)
    {
        // $request->validate(['password' => 'required']);

        // Validate the token from the Authorization header
        $authorizationHeader = $request->header('Authorization'); // Get the full header
        if (!$authorizationHeader) {
            return response()->json(['error' => 'Authorization header is required'], 400);
        }

        // Extract the token part after "Bearer"
        $token = str_replace('Bearer ', '', $authorizationHeader);

        // Find the user by token
        $user = User::where('token', $token)->first();

        if (!$user) {
            return response()->json(['error' => 'Invalid or expired token.'], 400);
        }

        // Proceed with password setup
        $user->password = Hash::make($request->password);
        $user->save();

        return response()->json([
            'message' => 'Password setup successfully. Please log in to continue!',
            'redirect' => route('loginForm'),
            'password_token'=>$token,
        ]);
    }
}
