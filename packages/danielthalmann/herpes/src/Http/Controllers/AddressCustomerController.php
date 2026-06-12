<?php

namespace Danielthalmann\Herpes\Http\Controllers;

use Illuminate\Http\Request;

class AddressCustomerController extends Controller
{
    public function __invoke(Request $request, string $customer)
    {
        return view('herpes::address_customer', ['customer' => $customer]);
    }
}
