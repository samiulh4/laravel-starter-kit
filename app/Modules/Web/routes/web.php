<?php
use Illuminate\Support\Facades\Route;
use App\Modules\Web\Http\Controllers\WebController;

Route::get('/', [WebController::class, 'index'])->name('web.index');

Route::prefix('web')->group(function () {
    //Route::get('/', [WebController::class, 'index'])->name('web.index');
});

?>