<?php

use Danielthalmann\Herpes\Http\Controllers\CustomerController;
use Danielthalmann\Herpes\Http\Controllers\DashboardController;
use Danielthalmann\Herpes\Http\Controllers\GridController;
use Danielthalmann\Herpes\Http\Controllers\InvoicePrintController;
use Illuminate\Support\Facades\Route;


Route::group(['middleware' => ['web', 'auth']], function () {

    Route::get('/', DashboardController::class)->name('dashboard');
    Route::get('/customers/', CustomerController::class)->name('customer');
    Route::get('/invoices/{id}', InvoicePrintController::class)->name('invoice');
    Route::get('/balancesheets/{id?}', GridController::class)->name('balancesheet');

});
