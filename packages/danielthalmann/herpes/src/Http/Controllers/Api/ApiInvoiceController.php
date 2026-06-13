<?php

namespace Danielthalmann\Herpes\Http\Controllers\Api;

use Danielthalmann\Herpes\Http\Controllers\Controller;
use Danielthalmann\Herpes\Models\Invoice;
use Illuminate\Http\Request;

class ApiInvoiceController extends Controller
{
    public function index(Request $request)
    {
        $query = Invoice::query();

        if ($request->input('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('ref', 'like', '%' . $request->input('search') . '%')
                    ->orWhere('customer_name', 'like', '%' . $request->input('search') . '%')
                    ->orWhere('customer_company', 'like', '%' . $request->input('search') . '%');
            });
        }

        return $query->paginate($request->input('paginate', 20));
    }

    public function store(Request $request)
    {
        $invoice = new Invoice();
        $invoice->ref = $request->input('ref');
        $invoice->invoice_date = $request->input('invoice_date');
        $invoice->customer_id = $request->input('customer_id');
        $invoice->customer_company = $request->input('customer_company');
        $invoice->customer_department = $request->input('customer_department');
        $invoice->customer_name = $request->input('customer_name');
        $invoice->customer_street = $request->input('customer_street');
        $invoice->customer_zipcode = $request->input('customer_zipcode');
        $invoice->customer_city = $request->input('customer_city');
        $invoice->save();

        return $invoice;
    }

    /**
     * Create the specified resource.
     */
    public function create()
    {
        $invoice = new Invoice();

        return $invoice;
    }

    public function show(string $id)
    {
        return Invoice::query()->with('invoiceItems')->find($id);
    }

    public function update(Request $request, string $id)
    {
        $invoice = Invoice::query()->find($id);

        if ($invoice) {
            $invoice->ref = $request->input('ref');
            $invoice->invoice_date = $request->input('invoice_date');
            $invoice->customer_id = $request->input('customer_id');
            $invoice->customer_company = $request->input('customer_company');
            $invoice->customer_department = $request->input('customer_department');
            $invoice->customer_name = $request->input('customer_name');
            $invoice->customer_street = $request->input('customer_street');
            $invoice->customer_zipcode = $request->input('customer_zipcode');
            $invoice->customer_city = $request->input('customer_city');
            $invoice->save();
        }

        return $invoice;
    }

    public function destroy(string $id)
    {
        $invoice = Invoice::query()->find($id);
        if ($invoice) {
            $invoice->delete();
        }
        return $invoice;
    }
}
