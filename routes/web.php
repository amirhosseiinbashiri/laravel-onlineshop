<?php

use App\Http\Controllers\Admin\AttributeController;
use App\Http\Controllers\Admin\AttributeValueController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ProductVariantController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Customer\AddressController;
use App\Http\Controllers\Customer\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PannelController;
use App\Http\Controllers\ProfileController;

Route::get('/', [HomeController::class, 'index'])->name('page.home');
Route::get('/category/{category:slug}', [HomeController::class, 'category'])->name('page.category');

Route::middleware('guest')->prefix('auth')->group(function () {
    // ثبت‌نام
    Route::get('/register', [RegisterController::class, 'showRegisterForm'])->name('register.form');
    Route::post('/register', [RegisterController::class, 'register'])->name('register.submit');
    Route::get('/verify', [RegisterController::class, 'showVerifyForm'])->name('verify.form');
    Route::post('/verify', [RegisterController::class, 'verify'])->name('verify.submit');
    Route::post('/verify/resend', [RegisterController::class, 'resendOtp'])->name('verify.resend');

    // ورود
    Route::get('/login', [RegisterController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [RegisterController::class, 'login'])->name('login.submit');
    Route::get('/login/otp', [RegisterController::class, 'showLoginOtpForm'])->name('login.otp');
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
        Route::get('/profile', [ProfileController::class, 'show'])->name('dashboard.profile.show');
        Route::delete('/profile/delete', [ProfileController::class, 'destroyAccount'])->name('dashboard.profile.delete');
        Route::resource('addresses', AddressController::class)
            ->names('dashboard.addresses')
            ->except(['show']);
    });
});

Route::middleware(['auth', 'is_admin'])->prefix('pannel')->group(function () {
    Route::get('/', [PannelController::class, 'index'])->name('pannel');
    Route::resource('categories', CategoryController::class);
    Route::resource('products', ProductController::class);
    Route::resource('products.variants', ProductVariantController::class);
    Route::resource('attributes', AttributeController::class);
    Route::resource('attributes.values', AttributeValueController::class);
});

Route::prefix('api')->group(function () {
    Route::get('/provinces', [AddressController::class, 'getProvinces']);
    Route::get('/cities/{province}', [AddressController::class, 'getCities']);

});
