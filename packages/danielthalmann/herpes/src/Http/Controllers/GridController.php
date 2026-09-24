<?php

namespace Danielthalmann\Herpes\Http\Controllers;

use Danielthalmann\Herpes\Models\BalanceSheet;
use Danielthalmann\Herpes\Models\BalanceSheetItem;
use Illuminate\Http\Request;

class GridController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, string $id)
    {
        $balanceSheet = BalanceSheet::query()->findOrFail($id);
        $items = BalanceSheetItem::where('balance_sheet_id', $balanceSheet->id);

        return view('herpes::balance', compact('items', 'balanceSheet'));
    }
}
