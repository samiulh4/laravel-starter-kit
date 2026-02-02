<?php

use Illuminate\Support\Facades\Route;
use App\Modules\User\Http\Controllers\AdminAuthUserController;
use App\Modules\User\Http\Controllers\WebAuthUserController;

Route::group([
    'prefix' => 'admin/auth',
    'middleware' => ['auth']
], function () {
    Route::get('/user/profile-edit', [AdminAuthUserController::class, 'userProfileEdit'])->name('admin.auth.user.profile.edit');
});

Route::group([
    'prefix' => '/auth',
    'middleware' => ['auth']
], function () {
    Route::get('/user/profile-view', [WebAuthUserController::class, 'userProfileView']);
});
