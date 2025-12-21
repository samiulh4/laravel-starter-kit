<?php

use Illuminate\Support\Facades\Route;
use App\Modules\Ecommerce\Http\Controllers\EcommerceWebController;
use App\Modules\Ecommerce\Http\Controllers\CartController;
use App\Modules\Ecommerce\Http\Controllers\ProductController;

Route::prefix('/ecommerce')->group(function () {
    Route::get('/', [EcommerceWebController::class, 'index'])->name('ecommerce.home');
    Route::get('/products', [ProductController::class, 'index'])->name('products.index');
    Route::get('/products/{slug}', [ProductController::class, 'show'])->name('products.show');
    Route::get('/api/products', [ProductController::class, 'getProducts'])->name('products.api');
});

Route::middleware('auth')->prefix('/cart')->group(function () {
    Route::get('/', [CartController::class, 'index'])->name('cart.index');
    Route::post('/add', [CartController::class, 'add'])->name('cart.add');
    Route::post('/api/add', [CartController::class, 'addToCart'])->name('cart.api.add');
    Route::patch('/api/{id}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/api/{productId}', [CartController::class, 'removeItem'])->name('cart.api.remove');
    Route::delete('/{productId}', [CartController::class, 'remove'])->name('cart.remove');
    Route::delete('/', [CartController::class, 'clear'])->name('cart.clear');
    Route::get('/api/count', [CartController::class, 'getCount'])->name('cart.api.count');
});
