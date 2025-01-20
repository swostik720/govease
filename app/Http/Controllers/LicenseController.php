<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\License;

class LicenseController extends Controller
{
    public function showForm()
    {
        return response()->json([
            'message' => 'License form data retrieved successfully.',
            'license_form_url' => url('/license-form'), // Optionally include the URL to the form
        ], 200);
    }

    public function verify(Request $request)
    {

        $license = License::where('license_number', $request->license_number)
            ->where('name', $request->name)
            ->first();
        if ($license) {
            return response()->json([
                'message'=>'congratulation you have verified license successfully!'

            ]);
        }

        return response()->json([
            "message"=>"licence credential do not match",
            "licence"=>$license
        ]);


    }
}

