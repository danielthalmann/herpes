<?php

namespace App\Filament\Resources\Customers\Resources\AddressCustomers\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class AddressCustomerInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('customer_id')
                    ->numeric(),
                TextEntry::make('company'),
                TextEntry::make('department'),
                TextEntry::make('name'),
                TextEntry::make('street'),
                TextEntry::make('zipcode'),
                TextEntry::make('city'),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
