<?php

use App\Http\Controllers\Api\AdminController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ReviewController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('user')->controller(UserController::class)->group(function(){
Route::post('register','register');
Route::post('login','login');
Route::post('logout','logout');
});

Route::prefix('admin')->controller(AdminController::class)->group(function(){
Route::post('register','register');
Route::post('login','login');
Route::post('logout','logout');
Route::get('stats','stats')->middleware('auth:admin');
});

Route::prefix('product')->controller(ProductController::class)->middleware('auth:user,admin')->group(function(){
Route::get('getallproducts','getallproducts');
Route::get('getcategory/{slug}','getcategory');
Route::get('showproduct/{id}','showproduct');
});

Route::prefix('cart')->controller(CartController::class)->middleware('auth:user')->group(function(){
Route::get('cart','index');
Route::post('add/{id}','add');
});

Route::prefix('category')->controller(CategoryController::class)->middleware('auth:admin')->group(function(){
    Route::post('addcategory','create');
    Route::put('update/{slug}','edit');
    Route::delete('delete/{slug}','delete');
});

Route::prefix('product')->controller(ProductController::class)->middleware('auth:admin')->group(function(){
    Route::post('create','create');
    Route::patch('update/{product}','update');
    Route::delete('delete/{product}','delete');
});

Route::prefix('review')->controller(ReviewController::class)->middleware('auth:user')->group(function(){
    Route::post('create','create');
});

Route::prefix('review')->controller(ReviewController::class)->middleware('auth:admin')->group(function(){
    Route::get('allreviews','all');
});
