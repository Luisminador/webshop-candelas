<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\Admin\OrderController;

// 🏠 Startsida
Route::get('/', function () {
    return redirect()->route('store.index');
});

// 🔐 Auth + Dashboard
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// 🔧 Admin-routes (CRUD)
Route::resource('products', ProductController::class);
Route::get('/products/category/{id}', [ProductController::class, 'filterByCategory'])->name('products.byCategory');
Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');

// ✅ Adminvy: ordrar
Route::get('/admin/orders', [OrderController::class, 'index'])
    ->middleware('auth')->name('admin.orders.index');

Route::delete('/admin/orders/{order}', [OrderController::class, 'destroy'])
    ->middleware('auth')->name('admin.orders.destroy');

// 🛍️ Kundvy-routes
Route::get('/butik', [StoreController::class, 'index'])->name('store.index');
Route::get('/produkt/{product}', [StoreController::class, 'show'])->name('store.show');

// 🛒 Kundvagn (Cart)
Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');
Route::get('/varukorg', [CartController::class, 'index'])->name('cart.index');
Route::patch('/varukorg/{id}', [CartController::class, 'update'])->name('cart.update');
Route::delete('/varukorg/{id}', [CartController::class, 'remove'])->name('cart.remove');

// ✅ Checkout
Route::get('/kassa', [CheckoutController::class, 'index'])->name('checkout.index');
Route::post('/kassa', [CheckoutController::class, 'process'])->name('checkout.process');

require __DIR__.'/auth.php';
