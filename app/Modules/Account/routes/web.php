<?php
use Illuminate\Support\Facades\Route;
use App\Modules\Account\Http\Controllers\AdminAccountUserController;

Route::prefix('admin/account')->group(function () {
    Route::get('/user/edit', [AdminAccountUserController::class, 'accountUserEdit'])->name('admin.account.user.edit');
    Route::post('/user/update', [AdminAccountUserController::class, 'accountUserUpdate'])->name('admin.account.user.update');
    // AJAX CRUD Routes
   
    Route::post('/user/avatar/upload', [AdminAccountUserController::class, 'uploadAvatar'])->name('admin.account.user.avatar.upload');
    Route::post('/user/account/delete', [AdminAccountUserController::class, 'deleteAccount'])->name('admin.account.user.account.delete');
    Route::get('/user/profile', [AdminAccountUserController::class, 'getUserProfile'])->name('admin.account.user.profile.get');
});

?>