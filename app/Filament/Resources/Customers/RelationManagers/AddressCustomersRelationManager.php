<?php

namespace App\Filament\Resources\Customers\RelationManagers;

use App\Filament\Resources\Customers\Resources\AddressCustomers\AddressCustomerResource;
use Filament\Actions\CreateAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Table;

class AddressCustomersRelationManager extends RelationManager
{
    protected static string $relationship = 'AddressCustomers';

    protected static ?string $relatedResource = AddressCustomerResource::class;

    public function table(Table $table): Table
    {
        return $table
            ->headerActions([
                CreateAction::make(),
            ]);
    }

}
