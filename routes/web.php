<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

// // Route::get('/', [ProductController::class, 'index']);
// Route::post('/add-to-cart/{id}', [ProductController::class, 'addToCart']);
// Route::get('/remove/{id}', [ProductController::class, 'remove']);
// Route::post('/update/{id}', [ProductController::class, 'update']);
// Route::get('/cart', [ProductController::class, 'cart']);
// Route::get('/create', [ProductController::class, 'create']);
// Route::post('/store', [ProductController::class, 'store']);
// Route::get('/increase/{id}', [ProductController::class, 'increase'])->name('cart.increase');
// Route::get('/decrease/{id}', [ProductController::class, 'decrease'])->name('cart.decrease');
// // ទំព័រ Home
// Route::get('/', [ProductController::class, 'index'])->name('home');

// // ទំព័រ Shop
// Route::get('/shop', [ProductController::class, 'shop'])->name('shop');

// // ទំព័រ Categories
// Route::get('/categories', [ProductController::class, 'categories'])->name('categories');


// Cart Logic
Route::get('/cart', [ProductController::class, 'cart'])->name('cart');
Route::post('/add-to-cart/{id}', [ProductController::class, 'addToCart'])->name('cart.add');
Route::get('/remove/{id}', [ProductController::class, 'remove'])->name('cart.remove');
Route::get('/increase/{id}', [ProductController::class, 'increase'])->name('cart.increase');
Route::get('/decrease/{id}', [ProductController::class, 'decrease'])->name('cart.decrease');

// Product Management
Route::get('/create', [ProductController::class, 'create'])->name('product.create');
Route::post('/store', [ProductController::class, 'store'])->name('product.store');

// Navigation Pages
Route::get('/', [ProductController::class, 'index'])->name('home');
Route::get('/shop', [ProductController::class, 'shop'])->name('shop');
Route::get('/categories', [ProductController::class, 'categories'])->name('categories');

