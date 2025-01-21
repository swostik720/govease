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
        $user = Auth::user();
        $loginToken = $request->bearerToken();

        if (!$loginToken) {
            return response()->json(['error' => 'Invalid or missing login token.'], 401);
        }

        $verificationToken = $request->query('Verification-Token');

        if (!$verificationToken) {
            return response()->json(['error' => 'Verification token not provided.'], 400);
        }

        $validModels = [
            'citizenship' => Citizenship::class,
            'license' => License::class,
            'voter' => Voter::class,
            'pan' => Pan::class,
            'plus2' => Plus2::class,
            'birthcertificate' => BirthCertificate::class,
        ];

        $isValidToken = false;

        foreach ($validModels as $type => $model) {
            $record = $model::where('token', $verificationToken)->first();
            if ($record) {
                $isValidToken = true;

                // Link the record to the authenticated user if not already linked
                if ($record->user_id !== $user->id) {
                    $record->user_id = $user->id;
                    $record->save();
                }
            }
        }

        if (!$isValidToken) {
            return response()->json(['error' => 'Invalid or unauthorized verification token.'], 403);
        }

        $formsData = [];
        foreach ($validModels as $type => $model) {
            $formsData[$type] = $model::where('user_id', $user->id)
                ->where('token', $verificationToken)
                ->with(['user'])
                ->get();
        }

        return response()->json([
            'message' => 'Form data retrieved successfully',
            'forms' => array_keys($validModels),
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
        $user = Auth::user();
        $loginToken = $request->bearerToken();

        if (!$loginToken) {
            return response()->json(['error' => 'Invalid or missing login token.'], 401);
        }

        $verificationToken = $request->query('Verification-Token');

        if (!$verificationToken) {
            return response()->json(['error' => 'Verification token not provided.'], 400);
        }

        $validModels = [
            'citizenship' => Citizenship::class,
            'license' => License::class,
            'voter' => Voter::class,
            'pan' => Pan::class,
            'plus2' => Plus2::class,
            'birthcertificate' => BirthCertificate::class,
        ];

        if (!array_key_exists($type, $validModels)) {
            return response()->json(['error' => 'Invalid form type'], 404);
        }

        $model = $validModels[$type];
        $record = $model::where('token', $verificationToken)->first();

        if ($record) {
            if ($record->user_id !== $user->id) {
                $record->user_id = $user->id;
                $record->save();
            }
        } else {
            return response()->json(['error' => 'Invalid or unauthorized verification token.'], 403);
        }

        $data = $model::where('user_id', $user->id)->get();

        return response()->json([
            'message' => 'Form data retrieved successfully',
            'data' => $data,
        ], 200);
    }
}
