<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\License;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;


class LicenseController extends Controller
{
    public function showForm()
    {
        return response()->json(['message' => 'Please enter your license details.']);
    }

    public function verify(Request $request)
    {
        $request->validate(['license_number' => 'required', 'name' => 'required']);

        $license = License::where('license_number', $request->license_number)
            ->where('name', $request->name)
            ->first();

        if ($license) {
            // Generate a simple random token
            $token = Str::random(60);  // 60-character random string

            // Store the token in the database or in a separate table (optional)
            $license->token = $token;
            $license->save(); // Save token to database
        }

        if ($license) {
            return response()->json([
                'message' => 'License verified successfully.',
                'token' => $token,
                'redirect' => route('setup-password.form'),
            ], 200);
        }

        return response()->json(['error' => 'Invalid license details.'], 400);
    }
}
