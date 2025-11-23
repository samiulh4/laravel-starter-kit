<?php
use Illuminate\Support\Facades\Route;
use App\Modules\Authentication\Http\Controllers\AuthenticationController;

//Route::get('/unauthenticated', [AuthenticationAdminController::class, 'unAuthenticated']);

Route::group(['prefix' => '/auth'], function () {
    Route::get('/sign-up', [AuthenticationController::class, 'authSignUp']);
    Route::get('/sign-in', [AuthenticationController::class, 'authSignIn']);
    Route::post('/sign-up', [AuthenticationController::class, 'authRegister']);
    Route::post('/sign-in', [AuthenticationController::class, 'authLogin']);
    Route::post('/sign-out', [AuthenticationController::class, 'authSignOut'])->middleware('auth');
});


?>