<?php
use Illuminate\Support\Facades\Route;
use App\Modules\Account\Http\Controllers\AdminAccountUserController;

Route::prefix('admin/account')->group(function () {
    Route::get('/user/edit', [AdminAccountUserController::class, 'accountUserEdit'])->name('admin.account.user.edit');
});

?>