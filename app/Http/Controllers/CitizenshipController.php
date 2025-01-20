<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Citizenship;
use Illuminate\Support\Facades\Session;

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
            // Store user ID in session
            Session::put('verified_user_id', $citizenship->user_id);
        }

        if ($citizenship) {
            return response()->json([
                'message' => 'Citizenship verified successfully.',
                'redirect' => route('setup-password.form'),
            ], 200);
        }

        return response()->json(['error' => 'Invalid citizenship details.'], 400);
    }
}
