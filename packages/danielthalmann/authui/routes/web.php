<?php

use Danielthalmann\AuthUi\Http\Controllers\AuthController;

Route::group(['middleware' => ['web']], function () {
    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/login', [AuthController::class, 'credentials'])->middleware(['throttle:login'])->name('credentials');
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
});