<?php

namespace App\Http\Controllers;

use App\Models\Citizenship;
use App\Models\License;
use App\Models\Pan;
use App\Models\Plus2;
use App\Models\Voter;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function showForm($type)
    {
        if (!in_array($type, ['citizenship', 'license', 'voter', 'pan', 'plus2'])) {
            abort(404, 'Invalid form type');
        }
        return view("home.forms.$type"); // Show form based on type (e.g., 'citizenship')
    }

    public function verify(Request $request, $type)
    {
        // Validate the input fields 'number' and 'name'
        $request->validate([
            'number' => 'required',  // Validate the input number
            'name' => 'required|string', // Validate the name field
        ]);

        $data = null;

        // Simulate database matching based on type
        switch ($type) {
            case 'citizenship':
                $data = Citizenship::where('number', $request->number)
                    ->where('name', $request->name)
                    ->first();
                break;
            case 'license':
                $data = License::where('license_number', $request->number)
                    ->where('name', $request->name)
                    ->first();
                break;
            case 'voter':
                $data = Voter::where('voter_number', $request->number)
                    ->where('name', $request->name)
                    ->first();
                break;
            case 'pan':
                $data = Pan::where('pan_number', $request->number)
                    ->where('name', $request->name)
                    ->first();
                break;
            case 'plus2':
                $data = Plus2::where('symbol_number', $request->number)
                    ->where('name', $request->name)
                    ->first();
                break;
            default:
                abort(404, 'Invalid type');
        }

        if ($data) {
            // Dynamically determine the card view based on the type
            $viewName = "home.cards.{$type}_card";

            // Check if the view exists
            if (!view()->exists($viewName)) {
                abort(404, "Card view for type '{$type}' does not exist.");
            }

            return view($viewName, ['data' => $data]); // Pass data to the specific card view
        }

        return back()->withErrors(['number' => 'Details do not match our records.']);
    }
}
