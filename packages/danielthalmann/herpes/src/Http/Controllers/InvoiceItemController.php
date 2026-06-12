<?php

namespace Danielthalmann\Herpes\Http\Controllers;

use Illuminate\Http\Request;

class InvoiceItemController extends Controller
{
    public function __invoke(Request $request, string $invoice)
    {
        return view('herpes::invoice_item', ['invoice' => $invoice]);
    }
}
