<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Citizenship;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class CitizenshipController extends Controller
{
    public function showForm()
    {
        return response()->json([
            'message' => 'Please enter your citizenship details.',
            'redirect' => url('/citizenship/verify')
        ]);
    }

    public function verify_citizenship(Request $request)
    {
        $request->validate(['number' => 'required', 'name' => 'required']);

        $citizenship = Citizenship::where('number', $request->number)
            ->where('name', $request->name)
            ->first();

        if ($citizenship) {
            // Generate a simple random token
            $token = Str::random(60);  // 60-character random string

            // Store the token in the database or in a separate table (optional)
            $citizenship->token = $token;
            $citizenship->save(); // Save token to database
        }

        if ($citizenship) {
            return response()->json([
                'message' => 'Citizenship verified successfully.',
                'token' => $token,
                'redirect' => route('setup-password.form'),
            ], 200);
        }

        return response()->json(['error' => 'Invalid citizenship details.'], 400);
    }
}
