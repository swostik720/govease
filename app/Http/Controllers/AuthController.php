<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    public function showApiLogin()
    {
        return response()->json([
            'message' => 'please login to continue!',
            'redirect' => route('login'),
        ]);
    }

    // API Login Function
    public function apiLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($request->only('email', 'password'))) {
            $user = Auth::user();

            // Ensure email is verified
            // if (!$user->email_verified_at) {
            //     Auth::logout();
            //     return response()->json(['message' => 'Please verify your email address.'], 403);
            // }

            // Generate a token for API authentication
            $token = $user->createToken('API Token')->plainTextToken;

            return response()->json([
                'message' => 'Login successful',
                'user' => $user,
                'login-token' => $token,
                'redirect' => url('/api/home')
            ], 200);
        }

        return response()->json(['message' => 'Invalid credentials.'], 401);
    }

    // API Logout Function
    public function apiLogout(Request $request)
    {
        $user = $request->user();
        $user->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Logged out successfully.',
            'redirect' => route('loginForm'),
        ], 200);
    }

    public function showApiForgotPassword()
    {
        return response()->json([
            'message' => 'Forget your password? Send password reset link to your email!',
            'redirect' => route('apiForgotPassword'),
        ]);
    }

    // API Forgot Password
    public function apiForgotPassword(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        // Check if the user exists
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json(['message' => 'No user found with that email.'], 404);
        }

        // Create a unique token for the password reset
        $token = Str::random(60);

        // Store this token in the database (optional - useful for tracking resets)
        DB::table('password_resets')->insert([
            'email' => $request->email,
            'token' => $token,
            'created_at' => now(),
        ]);

        // Create custom reset link
        $passwordResetUrl = 'passwordResetForm/';
        // $resetUrl = config($passwordResetUrl . $token . '?email=' . urlencode($request->email));
        // Create custom reset link for the frontend
        $resetUrl = config('app.frontend_url') . '/resetpassword?token=' . $token . '&email=' . urlencode($request->email);

        // Send raw email with custom message
        Mail::raw("To reset your password, click the following link: $resetUrl", function ($message) use ($request) {
            $message->to($request->email)
                ->subject('Password Reset Request');
        });

        return response()->json([
            'message' => 'Password reset link sent to your email.',
            'reset-token' => $token,
            'redirect' => route('showApiResetPassword'),
        ], 200);
    }

    public function showApiResetPassword()
    {
        return response()->json([
            'message' => 'Set your new password!',
            'redirect' => route('apiResetPassword'),
        ]);
    }

    // API Reset Password
    public function apiResetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:4',
        ]);

        // Check if the reset token exists in the database
        $reset = DB::table('password_resets')
            ->where('email', $request->email)
            ->where('token', $request->token)
            ->first();

        if (!$reset) {
            return response()->json(['message' => 'Invalid or expired reset token.'], 400);
        }

        // Update the user's password
        $user = User::where('email', $request->email)->first();

        if ($user) {
            $user->password = bcrypt($request->password);
            $user->save();

            // Optionally delete the reset token after use
            DB::table('password_resets')->where('email', $request->email)->delete();

            return response()->json([
                'message' => 'Password reset successful.',
                'redirect' => route('login'),
            ], 200);
        }

        return response()->json(['message' => 'User not found.'], 404);
    }
}
