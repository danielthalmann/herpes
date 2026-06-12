<?php

namespace Danielthalmann\Herpes\Http\Controllers;

use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function __invoke(Request $request)
    {
        return view('herpes::transaction');
    }
}
