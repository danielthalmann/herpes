<?php

use App\Http\Controllers\InvoicePrintController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    //return view('welcome');
    return redirect('/admin');
});

Route::get('/invoice/{id}', InvoicePrintController::class)->name('invoce');
