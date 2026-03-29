<?php

namespace App\Filament\Resources\Customers\Resources\AddressCustomers\Pages;

use App\Filament\Resources\Customers\Resources\AddressCustomers\AddressCustomerResource;
use Filament\Resources\Pages\CreateRecord;

class CreateAddressCustomer extends CreateRecord
{
    protected static string $resource = AddressCustomerResource::class;
}
