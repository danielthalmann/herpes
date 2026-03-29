<?php

namespace App\Filament\Resources\Customers\Resources\AddressCustomers;

use App\Filament\Resources\Customers\CustomerResource;
use App\Filament\Resources\Customers\Resources\AddressCustomers\Pages\CreateAddressCustomer;
use App\Filament\Resources\Customers\Resources\AddressCustomers\Pages\EditAddressCustomer;
use App\Filament\Resources\Customers\Resources\AddressCustomers\Pages\ViewAddressCustomer;
use App\Filament\Resources\Customers\Resources\AddressCustomers\Schemas\AddressCustomerForm;
use App\Filament\Resources\Customers\Resources\AddressCustomers\Schemas\AddressCustomerInfolist;
use App\Filament\Resources\Customers\Resources\AddressCustomers\Tables\AddressCustomersTable;
use App\Models\AddressCustomer;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class AddressCustomerResource extends Resource
{
    protected static ?string $model = AddressCustomer::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $parentResource = CustomerResource::class;

    public static function form(Schema $schema): Schema
    {
        return AddressCustomerForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return AddressCustomerInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return AddressCustomersTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'create' => CreateAddressCustomer::route('/create'),
            'view' => ViewAddressCustomer::route('/{record}'),
            'edit' => EditAddressCustomer::route('/{record}/edit'),
        ];
    }
}
