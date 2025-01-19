<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Citizenship;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CitizenshipController extends Controller
{
    public function showForm()
    {
        return response()->json([
            'message' => 'Citizenship form data retrieved successfully.',
            'citizenship_form_url' => url('/citizenship-form'), // Optionally include the URL to the form
        ], 200);    
    }

    public function verify_citizenship(Request $request)
    {
     
        // Check the database for matching citizenship details
        $citizenship = Citizenship::where('number', $request->number)
            ->where('name', $request->name)
            ->first();
        if ($citizenship) {
            // Respond with success and a redirect URL
            return response()->json([
                'message' => 'Citizenship verified successfully.',
                // 'redirect' => route('api.setupPassword'), // Replace with the API route
            ], 200);
        }
    
        // Respond with an error if verification fails
        return response()->json([
            'error' => 'Citizenship details do not match.',
            'citizenship'=>$citizenship
        ], 400);
    }
    
}

