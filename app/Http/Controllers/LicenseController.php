<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\License;
use Illuminate\Support\Facades\Session;

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
                // Store user ID in session
                Session::put('verified_user_id', $license->user_id);
            }

        if ($license) {
            return response()->json([
                'message' => 'License verified successfully.',
                'redirect' => route('setup-password.form'),
            ], 200);
        }

        return response()->json(['error' => 'Invalid license details.'], 400);
    }
}
