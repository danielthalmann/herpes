<?php

namespace App\Filament\Resources\Customers\Resources\AddressCustomers\Pages;

use App\Filament\Resources\Customers\Resources\AddressCustomers\AddressCustomerResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewAddressCustomer extends ViewRecord
{
    protected static string $resource = AddressCustomerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
