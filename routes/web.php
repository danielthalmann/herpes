<?php

use App\Http\Controllers\GridController;
use App\Http\Controllers\InvoicePrintController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    //return view('welcome');
    return redirect('/admin');
});

Route::get('/invoices/{id}', InvoicePrintController::class)->name('invoice');
Route::get('/balancesheets/{id?}', GridController::class)->name('balancesheet');
