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
            return response()->json([
                'message' => 'User is already logged in.',
                'redirect' => route('home') // Provide the route to redirect if needed
            ], 200); // Redirect to the dashboard if logged in
        }

        return response()->json([
            'message' => 'Please verify your email to proceed 123.'
        ], 200); // Show the verify email form if not verified
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


        return response()->json([
            'message' => 'OTP sent successfully to your email.',
            'email' => $request->email,
        ], 200);
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
            session()->save();

            // Log in the user after email verification
            //Auth::login($user);
            return response()->json([
                'message' => 'Email verified successfully.',
                'user_id' => $user->id,
                // 'redirect' => route('api.selectOption'),
            ], 200);

        }
        return response()->json([
            'error' => 'Invalid or expired OTP.',
        ], 400);
    }


    public function showPasswordForm()
    {
        return response()->json([
            'message'=>'please enter the password to setup'
        ]); // Show the setup password form
    }

    public function setupPassword(Request $request)
    {

      // Get the authenticated user (the one that was logged in during email verification)
        //$user = Auth::user();
        $userId = session('user_id');

        if (!$userId) {

            return response()->json([
                'message'=>'session expired'
            ]);
        }

        $user = User::find($userId);

        if (!$user) {
            return response()->json([
                'message'=>'user not found!'
            ]);
        }


        // Save the hashed password
        $user->password = Hash::make($request->password);

        if ($user->save()) {
            return response()->json([
                'message'=>'password setup successfully.please login to continue!'
            ]);
        }

        return response()->json([
            'message'=>'failed to login'
        ]);
    }
}
