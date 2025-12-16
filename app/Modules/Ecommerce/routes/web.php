<?php

use Illuminate\Support\Facades\Route;
use App\Modules\Ecommerce\Http\Controllers\EcommerceWebController;

Route::prefix('/ecommerce')->group(function () {
    Route::get('/', [EcommerceWebController::class, 'index']);
});


Route::middleware('auth')->group(function () {
    
});
