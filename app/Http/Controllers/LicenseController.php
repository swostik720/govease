<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\License;

class LicenseController extends Controller
{
    public function showForm()
    {
        $a="hello";
        return $a;
    }

    public function verify(Request $request)
    {
       
        $license = License::where('license_number', $request->number)
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

