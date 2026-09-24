<?php

namespace Danielthalmann\Herpes\Http\Controllers;

use Illuminate\Http\Request;

class AccountController extends Controller
{
    public function __invoke(Request $request)
    {
        return view('herpes::account');
    }
}
