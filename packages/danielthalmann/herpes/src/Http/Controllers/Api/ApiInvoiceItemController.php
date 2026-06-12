<?php

namespace Danielthalmann\Herpes\Http\Controllers\Api;

use Danielthalmann\Herpes\Http\Controllers\Controller;
use Danielthalmann\Herpes\Models\InvoiceItem;
use Illuminate\Http\Request;

class ApiInvoiceItemController extends Controller
{
    public function index(Request $request, string $invoice)
    {
        $query = InvoiceItem::query()->where('invoice_id', $invoice);

        if ($request->input('search')) {
            $query->where('description', 'like', '%' . $request->input('search') . '%');
        }

        return $query->paginate($request->input('paginate', 20));
    }

    public function store(Request $request, string $invoice)
    {
        $item = new InvoiceItem();
        $item->invoice_id = $invoice;
        $item->no = $request->input('no');
        $item->description = $request->input('description');
        $item->quantity = $request->input('quantity');
        $item->unit_price = $request->input('unit_price');
        $item->currency = $request->input('currency');
        $item->quantity_type = $request->input('quantity_type');
        $item->save();

        return $item;
    }

    public function show(string $invoice, string $item)
    {
        return InvoiceItem::query()
            ->where('invoice_id', $invoice)
            ->find($item);
    }

    public function update(Request $request, string $invoice, string $item)
    {
        $invoiceItem = InvoiceItem::query()
            ->where('invoice_id', $invoice)
            ->find($item);

        if ($invoiceItem) {
            $invoiceItem->no = $request->input('no');
            $invoiceItem->description = $request->input('description');
            $invoiceItem->quantity = $request->input('quantity');
            $invoiceItem->unit_price = $request->input('unit_price');
            $invoiceItem->currency = $request->input('currency');
            $invoiceItem->quantity_type = $request->input('quantity_type');
            $invoiceItem->save();
        }

        return $invoiceItem;
    }

    public function destroy(string $invoice, string $item)
    {
        $invoiceItem = InvoiceItem::query()
            ->where('invoice_id', $invoice)
            ->find($item);

        if ($invoiceItem) {
            $invoiceItem->delete();
        }

        return $invoiceItem;
    }
}
