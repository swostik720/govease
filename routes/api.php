<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OtpController;
use App\Http\Controllers\CitizenshipController;
use App\Http\Controllers\ContactUsController;
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
            'option' => 'citizenship',
            // 'redirect' => route('api.citizenshipForm'),
        ], 200);
    }

    if ($selectedOption === 'license') {
        return response()->json([
            'option' => 'license',
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
Route::get('/license', [LicenseController::class, 'showForm'])->name('license.form');
Route::post('/license/verify', [LicenseController::class, 'verify'])->name('license.verify');

// Password Setup
Route::get('/setup-password', [OtpController::class, 'showPasswordForm'])->name('setup-password.form');
Route::post('/setup-password', [OtpController::class, 'setupPassword'])->name('setup-password');

// Authentication Routes
Route::get('/login', [AuthController::class, 'showApiLogin'])->name('loginForm');
Route::post('/login', [AuthController::class, 'apiLogin'])->name('login');
Route::get('/forgot-password', [AuthController::class, 'showApiForgotPassword'])->name('showApiForgotPassword');
Route::post('/forgot-password', [AuthController::class, 'apiForgotPassword'])->name('apiForgotPassword');
Route::get('/reset-password', [AuthController::class, 'showApiResetPassword'])->name('showApiResetPassword');
Route::post('/reset-password', [AuthController::class, 'apiResetPassword'])->name('apiResetPassword');

// Protected Routes
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'apiLogout']);
});

// Home Routes
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('/home/{type}', [HomeController::class, 'showForm']);
});

//Contact-us Routes
Route::post('/contact-us', [ContactUsController::class, 'store']);
