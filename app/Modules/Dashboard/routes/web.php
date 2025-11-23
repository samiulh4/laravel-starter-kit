<?php

use Illuminate\Support\Facades\Route;
use App\Modules\Dashboard\Http\Controllers\DashboardController;

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
});
