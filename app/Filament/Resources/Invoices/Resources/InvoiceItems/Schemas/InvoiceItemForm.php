<?php

namespace App\Filament\Resources\Invoices\Resources\InvoiceItems\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class InvoiceItemForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('no')
                    ->numeric(),
                TextInput::make('description'),
                TextInput::make('quantity')
                    ->numeric(),
                TextInput::make('unit_price')
                    ->numeric()
                    ->prefix('$'),
                TextInput::make('currency'),
                TextInput::make('quantity_type'),
            ]);
    }
}
