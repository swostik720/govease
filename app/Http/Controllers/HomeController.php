<?php

namespace App\Http\Controllers;

use App\Models\BirthCertificate;
use App\Models\Citizenship;
use App\Models\License;
use App\Models\Pan;
use App\Models\Plus2;
use App\Models\Voter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

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
     * List all available forms and the user's data for each form type.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
       // Get the authenticated user
       $user = Auth::user();

       // Get the verified user from the session
       $verifiedUserId = Session::get('verified_user_id');

       if (!$verifiedUserId || $verifiedUserId !== $user->id) {
           return response()->json(['error' => 'Unauthorized access'], 403);
       }

        // List of all available forms
        $formTypes = [
            'citizenship',
            'license',
            'voter',
            'pan',
            'plus2',
            'birthcertificate',
        ];

        // Get data for each form type for the authenticated user
        $formsData = [];
        foreach ($formTypes as $type) {
            $modelClass = '\\App\\Models\\' . ucfirst($type); // Dynamically get model class name
            $data = $modelClass::where('user_id', $user->id)->get();
            $formsData[$type] = $data;
        }

        // Return the list of forms and their data
        return response()->json([
            'message' => 'Welcome to the home API',
            'forms' => $formTypes,
            'data' => $formsData,
        ]);
    }

    /**
     * Show the form with all data from the respective table for the authenticated user.
     *
     * @param string $type
     * @return \Illuminate\Http\JsonResponse
     */
    public function showForm($type)
    {
        // Get the authenticated user
        $user = Auth::user();

        // Get the verified user from the session
        $verifiedUserId = Session::get('verified_user_id');

        if (!$verifiedUserId || $verifiedUserId !== $user->id) {
            return response()->json(['error' => 'Unauthorized access'], 403);
        }

        // Validate the type to prevent invalid API requests
        if (!in_array($type, ['citizenship', 'license', 'voter', 'pan', 'plus2', 'birthcertificate'])) {
            return response()->json(['error' => 'Invalid form type'], 404);
        }

        // Get data based on the type and the authenticated user
        $modelClass = '\\App\\Models\\' . ucfirst($type); // Dynamically get model class name
        $data = $modelClass::where('user_id', $user->id)->get();

        // Return the data as JSON
        return response()->json([
            'message' => 'Form data retrieved successfully',
            'data' => $data
        ], 200);
    }
}
