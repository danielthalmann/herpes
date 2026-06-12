<?php

use Danielthalmann\Herpes\Http\Controllers\AddressCustomerController;
use Danielthalmann\Herpes\Http\Controllers\Api\ApiAddressCustomerController;
use Danielthalmann\Herpes\Http\Controllers\Api\ApiCustomerController;
use Danielthalmann\Herpes\Http\Controllers\CustomerController;
use Danielthalmann\Herpes\Http\Controllers\DashboardController;
use Danielthalmann\Herpes\Http\Controllers\GridController;
use Danielthalmann\Herpes\Http\Controllers\InvoicePrintController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['web', 'auth']], function () {

    Route::get('/', DashboardController::class)->name('dashboard');
    Route::get('/customers/', CustomerController::class)->name('customer');
    Route::get('/customers/{customer}/addresses/', AddressCustomerController::class)->name('customer.address-customers');
    Route::get('/invoices/{id}', InvoicePrintController::class)->name('invoice');
    Route::get('/balancesheets/{id?}', GridController::class)->name('balancesheet');


});

Route::group(['middleware' => ['web', 'auth']], function () {
    Route::apiResource('/api/customer', ApiCustomerController::class);
    Route::apiResource('/api/customers/{customer}/addresses', ApiAddressCustomerController::class)->names([
        'index'   => 'address-customer.index',
        'store'   => 'address-customer.store',
        'show'    => 'address-customer.show',
        'update'  => 'address-customer.update',
        'destroy' => 'address-customer.destroy',
    ]);
});
