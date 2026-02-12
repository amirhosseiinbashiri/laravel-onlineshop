<?php

use App\Http\Controllers\Admin\ArchiveController;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\PannelController;
use App\Http\Controllers\Admin\PinController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\TagController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\Dashboard\AddressController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TestController;
use Illuminate\Support\Facades\Route;


// test routes
Route::prefix('test')->group(function () {
    Route::get('/', [TestController::class, 'index'])->name('test.index');
});

Route::prefix('/')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('/about', [HomeController::class, 'about'])->name('about');
    Route::get('/category/{category:slug}', [HomeController::class, 'category'])->name('category');
    Route::get('/products', [HomeController::class, 'products'])->name('products');
    Route::get('/product/{product:slug}', [HomeController::class, 'product'])->name('product');
    Route::get('/blogs', [HomeController::class, 'blogs'])->name('blogs');
    Route::get('/blog/{slug}', [HomeController::class, 'blog'])->name('blog');
});

Route::prefix('cart')->group(function () {
    Route::get('/', [CartController::class, 'index'])->name('cart.index');
    Route::post('/add', [CartController::class, 'add'])->name('cart.add');
    Route::post('/update', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/{product}', [CartController::class, 'remove'])->name('cart.remove');
    Route::post('/clear', [CartController::class, 'clear'])->name('cart.clear');
});


// auth
Route::middleware('guest')->group(function () {
    // register

    Route::get('/register', [RegisterController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register'])->name('register');


    // login

    Route::get('/login', [RegisterController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [RegisterController::class, 'login'])->name('login');
    Route::get('/login/otp', [RegisterController::class, 'showLoginOtpForm'])->name('login.otp');
    Route::post('/login/otp', [RegisterController::class, 'loginWithOtp'])->name('login.otp');
});

Route::middleware('auth')->group(function () {
    Route::post('/products/{product}/comments', [CommentController::class, 'store'])->name('comments.store');
});

// main pages
// Route::group(function () {});

// logout
Route::post('/logout', [RegisterController::class, 'logout'])->name('logout')->middleware('auth');

// dashboard
Route::middleware('auth')->prefix('dashboard')->group(function () {

    //dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::prefix('profile')->group(function () {
        Route::get('/', [ProfileController::class, 'show'])->name('profile.show');
        Route::post('/', [ProfileController::class, 'store'])->name('profile.store');
        Route::get('/create', [ProfileController::class, 'create'])->name('profile.create');
        Route::get('/edit', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::post('/update', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/avatar', [ProfileController::class, 'destroyAvatar'])->name('profile.avatar.destroy');
        Route::delete('/delete', [ProfileController::class, 'destroyAccount'])->name('profile.delete');
    });

    Route::prefix('address')->group(function () {
        Route::resource('addresses', AddressController::class)
            ->names('addresses')
            ->except(['show']);
    });
});


// pannel
Route::middleware(['auth', 'is_admin'])->prefix('pannel')->group(function () {
    Route::get('/', [PannelController::class, 'index'])->name('pannel');

    Route::resource('categories', CategoryController::class)->except(['create', 'show']);

    Route::resource('tags', TagController::class)->except(['create', 'show']);

    Route::resource('products', ProductController::class);

    Route::resource('blogs', BlogController::class);
    Route::resource('archives', ArchiveController::class);
    Route::resource('pins', PinController::class);
});


// api

Route::prefix('api')->group(function () {
    Route::get('/provinces', [AddressController::class, 'getProvinces']);
    Route::get('/cities/{province}', [AddressController::class, 'getCities']);
});

// error
Route::fallback(function () {
    return "404 page not found";
});




//     Route::post('/verify/resend', [RegisterController::class, 'resendOtp'])->name('verify.resend');
