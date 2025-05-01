<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StoreController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

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

// 🛍️ Kundvy-routes
Route::get('/butik', [StoreController::class, 'index'])->name('store.index');
Route::get('/produkt/{product}', [StoreController::class, 'show'])->name('store.show');

require __DIR__.'/auth.php';
