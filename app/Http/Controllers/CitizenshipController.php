<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Citizenship;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use App\Models\License;
use App\Models\BirthCertificate;
use App\Models\Pan;
use App\Models\Voter;
use App\Models\Plus2;


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

        // Check if the citizenship exists based on provided details
        $citizenship = Citizenship::where('number', $request->number)
            ->where('name', $request->name)
            ->first();

        if ($citizenship) {
            // Generate a universal token (60-character random string)
            $token = Str::random(60);

            // Save the token to the citizenship model
            $citizenship->token = $token;
            $citizenship->save();

            // Save the token to other models for the same user_id
            $userId = $citizenship->user_id;

            // List of other models to update
            $otherModels = [
                License::class,
                Voter::class,
                Pan::class,
                Plus2::class,
                BirthCertificate::class,
            ];

            foreach ($otherModels as $model) {
                $model::where('user_id', $userId)->update(['token' => $token]);
            }

            return response()->json([
                'message' => 'Citizenship verified successfully.',
                'citizenship-token' => $token,
                'redirect' => route('setup-password.form'),
            ], 200);
        }

        return response()->json(['error' => 'Invalid citizenship details.'], 400);
    }
}
