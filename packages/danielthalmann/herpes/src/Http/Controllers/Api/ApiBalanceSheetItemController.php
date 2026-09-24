<?php

namespace Danielthalmann\Herpes\Http\Controllers\Api;

use Danielthalmann\Herpes\Http\Controllers\Controller;
use Danielthalmann\Herpes\Models\BalanceSheetItem;
use Illuminate\Http\Request;

class ApiBalanceSheetItemController extends Controller
{
    public function index(Request $request, string $balancesheet)
    {
        $query = BalanceSheetItem::query()->where('balance_sheet_id', $balancesheet);

        if ($request->input('search')) {
            $query->where('description', 'like', '%' . $request->input('search') . '%');
        }

        return $query->paginate($request->input('paginate', 20));
    }

    public function store(Request $request, string $balancesheet)
    {
        $item = new BalanceSheetItem();
        $item->balance_sheet_id = $balancesheet;
        $item->balance_type = $request->input('balance_type');
        $item->description = $request->input('description');
        $item->amount = $request->input('amount');
        $item->currency = $request->input('currency');
        $item->save();

        return $item;
    }

    /**
     * Create the specified resource.
     */
    public function create(string $balancesheet)
    {
        $item = new BalanceSheetItem();
        $item->balance_sheet_id = $balancesheet;

        return $item;
    }

    public function show(string $balancesheet, string $item)
    {
        return BalanceSheetItem::query()
            ->where('balance_sheet_id', $balancesheet)
            ->find($item);
    }

    public function update(Request $request, string $balancesheet, string $item)
    {
        $balanceSheetItem = BalanceSheetItem::query()
            ->where('balance_sheet_id', $balancesheet)
            ->find($item);

        if ($balanceSheetItem) {
            $balanceSheetItem->balance_type = $request->input('balance_type');
            $balanceSheetItem->description = $request->input('description');
            $balanceSheetItem->amount = $request->input('amount');
            $balanceSheetItem->currency = $request->input('currency');
            $balanceSheetItem->save();
        }

        return $balanceSheetItem;
    }

    public function destroy(string $balancesheet, string $item)
    {
        $balanceSheetItem = BalanceSheetItem::query()
            ->where('balance_sheet_id', $balancesheet)
            ->find($item);

        if ($balanceSheetItem) {
            $balanceSheetItem->delete();
        }

        return $balanceSheetItem;
    }
}
