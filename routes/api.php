<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OtpController;
use App\Http\Controllers\CitizenshipController;
use App\Http\Controllers\LicenseController;
use App\Http\Controllers\HomeController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


// OTP and Email Verification Routes
Route::get('/verify-email', [OtpController::class, 'show']);
Route::post('/send-otp', [OtpController::class, 'sendOtp']);
Route::post('/verify-otp', [OtpController::class, 'verifyOtp']);
Route::get('/select-option', function () {
    return response()->json([
        'message'=>'enter the option to continue!'
    ]);
});

// Selection Route
Route::post('/select-option', function (Request $request) {


    // Get the selected option
    $selectedOption = $request->input('option');

    // Handle the selected option
    if ($selectedOption === 'citizenship') {
        return response()->json([
            'message' => 'Citizenship option selected.',
            // 'redirect' => route('api.citizenshipForm'),
        ], 200);
    }

    if ($selectedOption === 'license') {
        return response()->json([
            'message' => 'License option selected.',
            // 'redirect' => route('api.licenseForm'),
        ], 200);
    }

    // Return error for invalid option
    return response()->json([
        'error' => 'Invalid option selected.',
    ], 400);
});


// Citizenship Routes
Route::get('/citizenship', [CitizenshipController::class, 'showForm']);
Route::post('/citizenship/verify', [CitizenshipController::class, 'verify_citizenship']);

// License Routes
Route::get('/license', [LicenseController::class, 'showForm']);
Route::post('/license/verify', [LicenseController::class, 'verify']);

// Setup Password Routes
Route::middleware('web')->group(function () {
    Route::get('/setup-password', [OtpController::class, 'showPasswordForm']);
    Route::post('/setup-password', [OtpController::class, 'setupPassword']);
});

//Authentication Routes
Route::get('/login', [AuthController::class, 'showApiLogin']);
Route::post('/login', [AuthController::class, 'apiLogin']);
Route::get('/forgot-password', [AuthController::class, 'showApiForgotPassword']);
Route::post('/forgot-password', [AuthController::class, 'apiForgotPassword']);
Route::get('/reset-password', [AuthController::class, 'showApiResetPassword']);
Route::post('/reset-password', [AuthController::class, 'apiResetPassword']);

// Protected Routes
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'apiLogout']);
});

// Home Routes
Route::get('/home', [HomeController::class, 'index'])->name('api.home');
Route::get('/home/{type}', [HomeController::class, 'showForm'])->name('api.home.forms');
Route::post('/home/{type}', [HomeController::class, 'verify'])->name('api.home.verify');

