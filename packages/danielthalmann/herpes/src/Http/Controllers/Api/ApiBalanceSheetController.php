<?php

namespace Danielthalmann\Herpes\Http\Controllers\Api;

use Danielthalmann\Herpes\Http\Controllers\Controller;
use Danielthalmann\Herpes\Models\BalanceSheet;
use Danielthalmann\Herpes\Models\BalanceSheetItem;
use Illuminate\Http\Request;

class ApiBalanceSheetController extends Controller
{
    public function index(Request $request)
    {
        $query = BalanceSheet::query();

        if ($request->input('search')) {
            $query->where('balance_sheet_date', 'like', '%' . $request->input('search') . '%');
        }

        return $query->orderByDesc('balance_sheet_date')->paginate($request->input('paginate', 20));
    }

    public function store(Request $request)
    {
        $balanceSheet = new BalanceSheet();
        $balanceSheet->balance_sheet_date = $request->input('balance_sheet_date');
        $balanceSheet->save();

        return $balanceSheet;
    }

    /**
     * Create the specified resource.
     */
    public function create()
    {
        $balanceSheet = new BalanceSheet();

        return $balanceSheet;
    }

    public function show(string $id)
    {
        return BalanceSheet::query()->find($id);
    }

    public function update(Request $request, string $id)
    {
        $balanceSheet = BalanceSheet::query()->find($id);

        if ($balanceSheet) {
            $balanceSheet->balance_sheet_date = $request->input('balance_sheet_date');
            $balanceSheet->save();
        }

        return $balanceSheet;
    }

    public function destroy(string $id)
    {
        $balanceSheet = BalanceSheet::query()->find($id);
        if ($balanceSheet) {
            BalanceSheetItem::query()->where('balance_sheet_id', $balanceSheet->id)->delete();
            $balanceSheet->delete();
        }
        return $balanceSheet;
    }
}
