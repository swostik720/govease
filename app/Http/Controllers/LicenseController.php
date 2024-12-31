<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\License;

class LicenseController extends Controller
{
    public function showForm()
    {
        return view('license_form');
    }

    public function verify(Request $request)
    {
        $request->validate([
            'license_number' => 'required',
            'name' => 'required',
        ]);

        $license = License::where('license_number', $request->license_number)
            ->where('name', $request->name)
            ->first();

        if ($license) {
            return redirect()->route('setupPassword')->with('message', 'License verified successfully.');
        }

        return back()->withErrors(['error' => 'License details do not match.']);
    }
}

