<?php

namespace App\Http\Controllers;

use App\Models\BirthCertificate;
use App\Models\Citizenship;
use Illuminate\Http\Request;
use App\Models\License;
use App\Models\Pan;
use App\Models\Plus2;
use App\Models\Voter;
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
            $token = Str::random(60);  // 60-character random string

            $license->token = $token;
            $license->save();

            $userId = $license->user_id;

            $otherModels = [
                Citizenship::class,
                Voter::class,
                Pan::class,
                Plus2::class,
                BirthCertificate::class,
            ];

            foreach ($otherModels as $model) {
                $model::where('user_id', $userId)->update(['token' => $token]);
            }

            return response()->json([
                'message' => 'License verified successfully.',
                'license-token' => $token,
                'redirect' => route('setup-password.form'),
            ], 200);
        }

        return response()->json(['error' => 'Invalid license details.'], 400);
    }
}
