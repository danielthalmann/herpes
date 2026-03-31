<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;

class InvoicePrintController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, string $id)
    {
        $invoice = Invoice::with('invoiceItems')->find($id);
        return view('invoice', compact(['invoice']));
    }
}
