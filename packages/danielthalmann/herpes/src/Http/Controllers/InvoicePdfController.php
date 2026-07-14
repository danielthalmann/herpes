<?php

namespace Danielthalmann\Herpes\Http\Controllers;

use Barryvdh\Snappy\Facades\SnappyPdf;
use Danielthalmann\Herpes\Models\Invoice;
use Illuminate\Http\Request;

class InvoicePdfController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, string $id)
    {
        $invoice = Invoice::with('invoiceItems')->find($id);

        //$html = view('herpes::invoice', compact(['invoice']))->render();
        //$pdf = SnappyPdf::loadHTML($html);
        $pdf = SnappyPdf::loadView('herpes::invoice', compact(['invoice']));
        $pdf->setOptions(['allow' => true, 'user-style-sheet' => true]);
        return $pdf->download('invoice.pdf');

        /*
        $invoice = Invoice::with('invoiceItems')->find($id);
        return view('herpes::invoice', compact(['invoice']));
        */
    }
}
