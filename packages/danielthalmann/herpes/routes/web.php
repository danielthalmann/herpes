<?php

use Danielthalmann\Herpes\Http\Controllers\AddressCustomerController;
use Danielthalmann\Herpes\Http\Controllers\Api\ApiAddressCustomerController;
use Danielthalmann\Herpes\Http\Controllers\Api\ApiCustomerController;
use Danielthalmann\Herpes\Http\Controllers\Api\ApiInvoiceController;
use Danielthalmann\Herpes\Http\Controllers\Api\ApiInvoiceItemController;
use Danielthalmann\Herpes\Http\Controllers\Api\ApiTransactionController;
use Danielthalmann\Herpes\Http\Controllers\CustomerController;
use Danielthalmann\Herpes\Http\Controllers\DashboardController;
use Danielthalmann\Herpes\Http\Controllers\GridController;
use Danielthalmann\Herpes\Http\Controllers\InvoiceItemController;
use Danielthalmann\Herpes\Http\Controllers\InvoicePrintController;
use Danielthalmann\Herpes\Http\Controllers\InvoicesController;
use Danielthalmann\Herpes\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['web', 'auth']], function () {

    Route::get('/', DashboardController::class)->name('dashboard');
    Route::get('/customers/', CustomerController::class)->name('customer');
    Route::get('/customers/{customer}/addresses/', AddressCustomerController::class)->name('customer.address');
    Route::get('/invoices/', InvoicesController::class)->name('invoice');
    Route::get('/invoices/{invoice}/items/', InvoiceItemController::class)->name('invoice.item');
    Route::get('/invoices/{id}/print', InvoicePrintController::class)->name('invoice.print');
    Route::get('/transactions/', TransactionController::class)->name('transaction');
    Route::get('/balancesheets/{id?}', GridController::class)->name('balancesheet');

});

Route::group(['middleware' => ['web', 'auth']], function () {
    Route::apiResource('/api/customer', ApiCustomerController::class);
    Route::apiResource('/api/customers/{customer}/addresses', ApiAddressCustomerController::class)->names([
        'index'   => 'customer.address.index',
        'store'   => 'customer.address.store',
        'show'    => 'customer.address.show',
        'update'  => 'customer.address.update',
        'destroy' => 'customer.address.destroy',
    ]);
    Route::apiResource('/api/invoice', ApiInvoiceController::class);
    Route::apiResource('/api/invoices/{invoice}/items', ApiInvoiceItemController::class)->names([
        'index'   => 'invoice.item.index',
        'store'   => 'invoice.item.store',
        'show'    => 'invoice.item.show',
        'update'  => 'invoice.item.update',
        'destroy' => 'invoice.item.destroy',
    ]);
    Route::apiResource('/api/transaction', ApiTransactionController::class);
});
