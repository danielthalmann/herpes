<?php

namespace Danielthalmann\Herpes\Http\Controllers\Api;

use Danielthalmann\Herpes\Http\Controllers\Controller;
use Danielthalmann\Herpes\Models\Customer;
use Illuminate\Http\Request;

class ApiCustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Customer::query();

        if ($request->input('search')) {
            $query = Customer::query()->where('name', 'like', '%' . $request->input('search') . '%');
        }

        return $query->with('addresses')->paginate($request->input('paginate', 20));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $customer = new Customer();
        $customer->name = $request->input('name');
        $customer->save();

        return $customer;
    }

    /**
     * Create the specified resource.
     */
    public function create()
    {
        $customer = new Customer();

        return $customer;
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $customer = Customer::query()->with('addresses')->find($id);

        return $customer;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $customer = Customer::query()->find($id);

        return $customer;

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $customer = Customer::query()->find($id);

        if($customer) {
            $customer->name = $request->input('name');
            $customer->save();
        }

        return $customer;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $customer = Customer::query()->find($id);
        if($customer) {
            $customer->delete();
        }
        return $customer;

    }
}
