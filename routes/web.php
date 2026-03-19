<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AdminHomeController;
use App\Http\Controllers\Admin\AdminProductController;
use App\Http\Controllers\Admin\AdminCategoryController;
use App\Http\Controllers\Admin\AdminReviewController;
use App\Http\Controllers\Admin\AdminContactController;
use App\Http\Controllers\Admin\AdminOrderController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\AdminWarehouseController;
use App\Http\Controllers\Admin\AdminStockMovementController;
use App\Http\Controllers\Admin\AdminCustomerController;
use App\Http\Controllers\Admin\AdminInvoiceController;
use App\Http\Controllers\Admin\AdminPaymentController;
use App\Http\Controllers\Admin\AdminAuditController;
use App\Http\Controllers\Admin\AdminReportController;

Route::get('/', [ProductController::class , 'index'])->name('shop.index');
Route::get('/product/{id}', [ProductController::class , 'show'])->name('shop.show');

Route::middleware('auth')->group(function () {
    Route::get('/cart', [CartController::class , 'index'])->name('cart.index');
    Route::post('/cart/add/{productId}', [CartController::class , 'add'])->name('cart.add');
    Route::post('/cart/update/{id}', [CartController::class , 'update'])->name('cart.update');
    Route::delete('/cart/remove/{id}', [CartController::class , 'remove'])->name('cart.remove');
    Route::get('/category/{slug}', [ProductController::class , 'getcategory'])->name('shop.category');

    Route::get('/checkout', [OrderController::class , 'checkout'])->name('checkout.index');
    Route::post('/checkout', [OrderController::class , 'store'])->name('checkout.store');
    Route::get('/orders', [OrderController::class , 'index'])->name('orders.index');
});

// Auth::routes(); // Requires laravel/ui package. Run: composer require laravel/ui && php artisan ui bootstrap --auth
// For now, using manual placeholder or suggesting installation.
// Route::get('/login', function() { return view('auth.login'); })->name('login');
// Route::get('/register', function() { return "Register Page Placeholder"; })->name('register');
// Route::post('/logout', function() { auth()->logout(); return redirect('/'); })->name('logout');

Route::get('/home', [App\Http\Controllers\HomeController::class , 'index'])->name('home');

// Admin Routes
Route::prefix('admin')->group(function () {
    Route::get('/login', [AdminAuthController::class , 'showLogin'])->name('admin.login');
    Route::post('/login', [AdminAuthController::class , 'login'])->name('admin.login.submit');
    Route::post('/logout', [AdminAuthController::class , 'logout'])->name('admin.logout');

    Route::middleware('auth:admin-web')->group(function () {
            Route::get('/dashboard', [AdminHomeController::class , 'index'])->name('admin.dashboard');
            Route::get('/profile',[AdminHomeController::class,'profile'])->name('admin.profile');
            Route::post('/update/profile',[AdminHomeController::class,'edit'])->name('admin.update.profile');

            // Product Management
            Route::resource('products', AdminProductController::class)->names('admin.products');

            // Category Management
            Route::resource('categories', AdminCategoryController::class)->names('admin.categories');

            // Warehouse Management
            Route::resource('warehouses', AdminWarehouseController::class)->names('admin.warehouses');
            Route::resource('movements', AdminStockMovementController::class)->only(['index', 'create', 'store'])->names('admin.movements');

            // Customer Management (CRM)
            Route::resource('customers', AdminCustomerController::class)->names('admin.customers');

            // Invoicing System
            Route::get('/invoices', [AdminInvoiceController::class , 'index'])->name('admin.invoices.index');
            Route::get('/invoices/create', [AdminInvoiceController::class , 'create'])->name('admin.invoices.create');
            Route::post('/invoices', [AdminInvoiceController::class , 'store'])->name('admin.invoices.store');
            Route::get('/invoices/{invoice}', [AdminInvoiceController::class , 'show'])->name('admin.invoices.show');
            Route::post('/invoices/{invoice}/confirm', [AdminInvoiceController::class , 'confirm'])->name('admin.invoices.confirm');

            // Payments & Collections
            Route::resource('payments', AdminPaymentController::class)->only(['index', 'create', 'store'])->names('admin.payments');

            // Order Management
            Route::get('/orders', [AdminOrderController::class , 'index'])->name('admin.orders.index');
            Route::get('/orders/{order}', [AdminOrderController::class , 'show'])->name('admin.orders.show');
            Route::post('/orders/{order}/convert', [AdminOrderController::class , 'convertToInvoice'])->name('admin.orders.convert');
            Route::post('/orders/{order}/change', [AdminOrderController::class , 'changestatus'])->name('admin.order.change');

            // Reports & Audit
            Route::get('/audit', [AdminAuditController::class , 'index'])->name('admin.audit.index');
            Route::get('/reports', [AdminReportController::class , 'index'])->name('admin.reports.index');

            // User Management
            Route::get('/users', [AdminUserController::class , 'index'])->name('admin.users.index');

            // Review Management
            Route::get('/reviews', [AdminReviewController::class , 'index'])->name('admin.reviews.index');
            Route::delete('/reviews/{review}', [AdminReviewController::class , 'destroy'])->name('admin.reviews.destroy');

            // Contact Messages
            Route::get('/contacts', [AdminContactController::class , 'index'])->name('admin.contacts.index');
        }
        );
          });
            Auth::routes();
