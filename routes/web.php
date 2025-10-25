<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Customer\DashboardController;
use App\Http\Controllers\ProfileController;

Route::get('/', function () {
    return "Hello World";
});

Route::middleware('guest')->prefix('auth')->group(function () {
    // ثبت‌نام
    Route::get('/register', [RegisterController::class, 'showRegisterForm'])->name('register.form');
    Route::post('/register', [RegisterController::class, 'register'])->name('register.submit');
    Route::get('/verify', [RegisterController::class, 'showVerifyForm'])->name('verify.form');
    Route::post('/verify', [RegisterController::class, 'verify'])->name('verify.submit');
    Route::post('/verify/resend', [RegisterController::class, 'resendOtp'])->name('verify.resend');

    // ورود
    Route::get('/login', [RegisterController::class, 'showLoginForm'])->name('login.form');
    Route::post('/login', [RegisterController::class, 'login'])->name('login.submit');
    Route::get('/login/otp', [RegisterController::class, 'showLoginOtpForm'])->name('login.otp.form');
    Route::post('/login/otp', [RegisterController::class, 'loginWithOtp'])->name('login.otp.submit');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [RegisterController::class, 'logout'])->name('logout');

    Route::prefix('dashboard')->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/profile/create', [ProfileController::class, 'create'])->name('dashboard.profile.create');
        Route::post('/profile', [ProfileController::class, 'store'])->name('dashboard.profile.store');
        Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('dashboard.profile.edit');
        Route::post('/profile/update', [ProfileController::class, 'update'])->name('dashboard.profile.update');
        Route::delete('/profile/avatar', [ProfileController::class, 'destroyAvatar'])->name('dashboard.profile.avatar.destroy');

    });
});
