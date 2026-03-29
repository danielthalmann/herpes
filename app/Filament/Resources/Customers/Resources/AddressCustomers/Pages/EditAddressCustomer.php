<?php

namespace App\Filament\Resources\Customers\Resources\AddressCustomers\Pages;

use App\Filament\Resources\Customers\Resources\AddressCustomers\AddressCustomerResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditAddressCustomer extends EditRecord
{
    protected static string $resource = AddressCustomerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
