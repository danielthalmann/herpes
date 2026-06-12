<?php

namespace Danielthalmann\Herpes\Http\Controllers\Api;

use Danielthalmann\Herpes\Http\Controllers\Controller;
use Danielthalmann\Herpes\Models\AddressCustomer;
use Illuminate\Http\Request;

class ApiAddressCustomerController extends Controller
{
    public function index(Request $request, string $customer)
    {
        $query = AddressCustomer::query()->where('customer_id', $customer);

        if ($request->input('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->input('search') . '%')
                    ->orWhere('company', 'like', '%' . $request->input('search') . '%');
            });
        }

        return $query->paginate($request->input('paginate', 20));
    }

    public function store(Request $request, string $customer)
    {
        $address = new AddressCustomer();
        $address->customer_id = $customer;
        $address->company = $request->input('company');
        $address->department = $request->input('department');
        $address->name = $request->input('name');
        $address->street = $request->input('street');
        $address->zipcode = $request->input('zipcode');
        $address->city = $request->input('city');
        $address->save();

        return $address;
    }

    public function show(string $customer, string $address_customer)
    {
        return AddressCustomer::query()
            ->where('customer_id', $customer)
            ->find($address_customer);
    }

    public function update(Request $request, string $customer, string $address_customer)
    {
        $address = AddressCustomer::query()
            ->where('customer_id', $customer)
            ->find($address_customer);

        if ($address) {
            $address->company = $request->input('company');
            $address->department = $request->input('department');
            $address->name = $request->input('name');
            $address->street = $request->input('street');
            $address->zipcode = $request->input('zipcode');
            $address->city = $request->input('city');
            $address->save();
        }

        return $address;
    }

    public function destroy(string $customer, string $address_customer)
    {
        $address = AddressCustomer::query()
            ->where('customer_id', $customer)
            ->find($address_customer);

        if ($address) {
            $address->delete();
        }

        return $address;
    }
}
