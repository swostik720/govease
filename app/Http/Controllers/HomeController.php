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

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     * List all available forms and the user's data for each form type.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        // Get the authenticated user
        $user = Auth::user();

        // Get the login token from the Authorization header
        $loginToken = $request->bearerToken();

        if (!$loginToken) {
            return response()->json(['error' => 'Invalid or missing login token.'], 401);
        }

        // Get the verification token from the request query
        $verificationToken = $request->query('Verification-Token');

        if (!$verificationToken) {
            return response()->json(['error' => 'Verification token not provided.'], 400);
        }

        // Check if the verification token matches for citizenship and license
        $citizenship = Citizenship::where('token', $verificationToken)->first();
        $license = License::where('token', $verificationToken)->first();

        // Update citizenship or license records with the user_id if applicable
        if ($citizenship) {
            if ($citizenship->user_id !== $user->id) {
                $citizenship->user_id = $user->id;
                $citizenship->save();  // Save the updated record
            }
        }

        if ($license) {
            if ($license->user_id !== $user->id) {
                $license->user_id = $user->id;
                $license->save();  // Save the updated record
            }
        }

        // If neither citizenship nor license are found, return an error
        if (!$citizenship && !$license) {
            return response()->json(['error' => 'Invalid or unauthorized verification token.'], 403);
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
            \Log::info("Fetching data for {$type} model where user_id = {$user->id}");

            switch ($type) {
                case 'citizenship':
                    // For citizenship, use verification token validation
                    if ($citizenship) {
                        $citizenshipData = Citizenship::where('user_id', $user->id)
                            ->select('*')
                            ->with(['user'])
                            ->get();
                        $formsData[$type] = $citizenshipData;
                    }
                    break;

                case 'license':
                    // For license, use verification token validation
                    if ($license) {
                        $licenseData = License::where('user_id', $user->id)
                            ->select('*')
                            ->with(['user'])
                            ->get();
                        $formsData[$type] = $licenseData;
                    }
                    break;

                case 'voter':
                case 'pan':
                case 'plus2':
                case 'birthcertificate':
                    // For these models, use both user_id and token validation
                    $data = $modelClass::where('user_id', $user->id)
                        ->where('token', $verificationToken)  // Check token as well
                        ->select('*')
                        ->with(['user'])
                        ->get();
                    $formsData[$type] = $data;  // Add data for the form type
                    break;

                default:
                    return response()->json(['error' => 'Invalid form type'], 404);
            }
        }

        // Return the response with all fetched data
        return response()->json([
            'message' => 'Form data retrieved successfully',
            'forms' => $formTypes,
            'data' => $formsData,
        ], 200);
    }




    /**
     * Show the form with all data from the respective table for the authenticated user.
     *
     * @param Request $request
     * @param string $type
     * @return \Illuminate\Http\JsonResponse
     */
    public function showForm(Request $request, $type)
    {
        // Get the authenticated user
        $user = Auth::user();

        // Get the login token from the Authorization header
        $loginToken = $request->bearerToken();

        if (!$loginToken) {
            return response()->json(['error' => 'Invalid or missing login token.'], 401);
        }

        // Compare the login token with the current user's token (if you're using Sanctum or Passport)
        // if ($user->currentAccessToken()->plainTextToken !== $loginToken) {
        //     return response()->json(['error' => 'Invalid or mismatched login token.'], 401);
        // }

        // Get the verification token from the request query
        $verificationToken = $request->query('Verification-Token');

        if (!$verificationToken) {
            return response()->json(['error' => 'Verification token not provided.'], 400);
        }

        // Check if the verification token matches any record (citizenship or license)
        $citizenship = Citizenship::where('token', $verificationToken)->first();
        $license = License::where('token', $verificationToken)->first();

        // Update citizenship or license records with the user_id, if applicable
        if ($citizenship) {
            // Set the user_id only if it's not already set
            if ($citizenship->user_id !== $user->id) {
                $citizenship->user_id = $user->id;
                $citizenship->save();  // Save the updated record
            }
        }

        if ($license) {
            // Set the user_id only if it's not already set
            if ($license->user_id !== $user->id) {
                $license->user_id = $user->id;
                $license->save();  // Save the updated record
            }
        }

        // If neither citizenship nor license is found, return an error
        if (!$citizenship && !$license) {
            return response()->json(['error' => 'Invalid or unauthorized verification token.'], 403);
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
