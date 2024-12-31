<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Citizenship;

class CitizenshipController extends Controller
{
    public function showForm()
    {
        return view('citizenship_form');
    }

    public function verify(Request $request)
    {
        $request->validate([
            'number' => 'required',
            'name' => 'required',
        ]);

        $citizenship = Citizenship::where('number', $request->number)
            ->where('name', $request->name)
            ->first();

        if ($citizenship) {
            return redirect()->route('setupPassword')->with('message', 'Citizenship verified successfully.');
        }

        return back()->withErrors(['error' => 'Citizenship details do not match.']);
    }
}

