<?php

use Illuminate\Support\Facades\Route;
use App\Modules\User\Http\Controllers\AdminAuthUserController;

Route::group([
    'prefix' => 'admin/auth',
    'middleware' => ['auth']
], function () {
    Route::get('/user/profile-edit', [AdminAuthUserController::class, 'userProfileEdit'])->name('admin.auth.user.profile.edit');
});
