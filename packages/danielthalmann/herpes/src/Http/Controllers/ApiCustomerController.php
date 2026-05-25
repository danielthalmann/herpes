<?php

namespace Danielthalmann\Herpes\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class ApiCustomerController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        return Customer::get();
    }
}
