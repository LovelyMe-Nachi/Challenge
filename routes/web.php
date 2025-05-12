<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Models\User;
use App\Models\OtpVerification;

Route::get('/', function () {
    return view('user.home');
});


// Show email input form (GET)
Route::get('/verify-email', [UserController::class, 'showEmailForm'])->name('auth.email');

// Handle email submission (POST)
Route::post('/send-otp', [UserController::class, 'sendOtp'])->name('send.otp');

// Show OTP input form (GET)
Route::get('/verify-otp', [UserController::class, 'showOtpForm'])->name('auth.otp');

// Handle OTP verification (POST)
Route::post('/verify-otp', [UserController::class, 'verifyOtp'])->name('otp.verify');

// Show registration form
Route::get('/register', function () {
    return view('auth.register');
})->name('register');
