<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;

Route::get('/', function () {
    return "Hello World";
});

Route::middleware('guest')->prefix('auth')->group(function () {
    Route::get('/register', [RegisterController::class, 'showRegisterForm'])->name('register.form');
    Route::post('/register', [RegisterController::class, 'register'])->name('register.submit');
    Route::get('/verify', [RegisterController::class, 'showVerifyForm'])->name('verify.form');
    Route::post('/verify', [RegisterController::class, 'verify'])->name('verify.submit');
    Route::post('/verify/resend', [RegisterController::class, 'resendOtp'])->name('verify.resend');
});

Route::get('/customer/dashboard', function () {
    return 'خوش آمدی، ' . auth()->user()->username;
})->name('customer.dashboard')->middleware('auth');
