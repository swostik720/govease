<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OtpController;
use App\Http\Controllers\CitizenshipController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LicenseController;
use App\Http\Controllers\HomeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/', [OtpController::class, 'show'])->name('verifyEmail');
Route::post('/send-otp', [OtpController::class, 'sendOtp'])->name('sendOtp');
Route::post('/verify-otp', [OtpController::class, 'verifyOtp'])->name('verifyOtp');

Route::get('/select-option', function () {
    return view('select_option');
})->name('selectOption');

Route::post('/select-option', function (Request $request) {
    $request->validate([
        'option' => 'required',
    ]);

    $selectedOption = $request->input('option');

    // dd($selectedOption);
    if ($selectedOption == 'citizenship') {
        return redirect()->route('citizenshipForm');
    }

    if ($selectedOption == 'license') {
        return redirect()->route('licenseForm');
    }

    return back()->withErrors(['option' => 'Invalid option selected.']);
});

Route::get('/citizenship', [CitizenshipController::class, 'showForm'])->name('citizenshipForm');
Route::post('/citizenship/verify', [CitizenshipController::class, 'verify'])->name('citizenshipVerify');

Route::get('/license', [LicenseController::class, 'showForm'])->name('licenseForm');
Route::post('/license/verify', [LicenseController::class, 'verify'])->name('licenseVerify');

Route::get('/setup-password', [OtpController::class, 'showPasswordForm'])->name('setupPassword');
Route::post('/setup-password', [OtpController::class, 'setupPassword'])->name('setupPassword.store');





Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/home/{type}', [HomeController::class, 'showForm'])->name('home.forms');
Route::post('/home/{type}', [HomeController::class, 'verify'])->name('home.verify');


