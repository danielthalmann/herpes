<?php

namespace Danielthalmann\Herpes\Http\Controllers;

use Illuminate\Http\Request;

class BalanceSheetItemController extends Controller
{
    public function __invoke(Request $request, string $balancesheet)
    {
        return view('herpes::balancesheet_item', ['balancesheet' => $balancesheet]);
    }
}
