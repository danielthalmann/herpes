<?php

namespace App\Filament\Resources\Customers\Resources\AddressCustomers\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class AddressCustomerForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                /*
                TextInput::make('customer_id')
                    ->required()
                    ->numeric(),
                    */
                TextInput::make('company')
                    ,
                TextInput::make('department')
                    ,
                TextInput::make('name')
                    ,
                TextInput::make('street')
                    ,
                TextInput::make('zipcode')
                    ,
                TextInput::make('city')
                    ,
            ]);
    }
}
