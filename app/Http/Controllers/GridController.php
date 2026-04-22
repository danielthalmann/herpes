<?php

namespace App\Http\Controllers;

use App\Models\BalanceSheet;
use App\Models\BalanceSheetItem;
use Illuminate\Http\Request;

class GridController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $balanceSheet = BalanceSheet::query()->first();
        $items = BalanceSheetItem::where('balance_sheet_id', $balanceSheet->id);

        return view('balance', compact('items', 'balanceSheet'));
    }
}
