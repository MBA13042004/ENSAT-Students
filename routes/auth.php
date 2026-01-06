<?php

use App\Http\Controllers\Auth\VerifyEmailController;
use Illuminate\Support\Facades\Route;

// Firebase custom authentication routes
Route::middleware('guest')->group(function () {
    Route::view('register', 'auth.firebase-register')->name('register');
    Route::view('login', 'auth.firebase-login')->name('login');
    Route::view('forgot-password', 'auth.firebase-forgot-password')->name('password.request');
});

// Email verification routes (keep for compatibility)
Route::middleware('auth')->group(function () {
    Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');
});
