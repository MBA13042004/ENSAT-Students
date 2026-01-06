<?php

use App\Http\Controllers\Auth\FirebaseAuthController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\StudentProfileController;
use Illuminate\Support\Facades\Route;

// Welcome page redirects to login
Route::get('/', function () {
    return redirect('/login');
});

// Firebase authentication endpoint
Route::post('/auth/firebase', [FirebaseAuthController::class, 'authenticate'])->name('firebase.auth');
Route::post('/logout', [FirebaseAuthController::class, 'logout'])->name('logout');

// Dashboard - redirect based on role
Route::get('/dashboard', function () {
    $user = auth()->user();
    
    if ($user->isAdmin()) {
        return redirect()->route('admin.students.index');
    }
    
    if ($user->isStudent()) {
        return redirect()->route('student.profile');
    }
    
    return redirect('/login');
})->middleware(['auth'])->name('dashboard');

// Admin routes - protected by auth and admin middleware
Route::middleware(['auth', App\Http\Middleware\EnsureUserIsAdmin::class])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('students', StudentController::class);
});

// Student routes - protected by auth middleware
Route::middleware(['auth'])->group(function () {
    Route::get('/student/profile', [StudentProfileController::class, 'show'])->name('student.profile');
});

// Breeze authentication routes (login, register, forgot password, etc.)
require __DIR__.'/auth.php';
