<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;

Route::get('/', [ProductController::class, 'index'])->name('shop.index');
Route::get('/product/{id}', [ProductController::class, 'show'])->name('shop.show');

Route::middleware('auth')->group(function () {
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{productId}', [CartController::class, 'add'])->name('cart.add');
    Route::post('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
    Route::get('/category/{slug}',[ProductController::class,'getcategory'])->name('shop.category');

    Route::get('/checkout', [OrderController::class, 'checkout'])->name('checkout.index');
    Route::post('/checkout', [OrderController::class, 'store'])->name('checkout.store');
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
});

// Auth::routes(); // Requires laravel/ui package. Run: composer require laravel/ui && php artisan ui bootstrap --auth
// For now, using manual placeholder or suggesting installation.
Route::get('/login', function() { return "Login Page Placeholder (Please install laravel/ui or breeze)"; })->name('login');
Route::get('/register', function() { return "Register Page Placeholder"; })->name('register');
Route::post('/logout', function() { auth()->logout(); return redirect('/'); })->name('logout');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
