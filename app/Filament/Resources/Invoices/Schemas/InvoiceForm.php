<?php

namespace App\Filament\Resources\Invoices\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class InvoiceForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('ref'),
                DatePicker::make('invoice_date')
                    ->required(),
                TextInput::make('customer_id')
                    ->required(),
                TextInput::make('customer_company'),
                TextInput::make('customer_department'),
                TextInput::make('customer_name'),
                TextInput::make('customer_street'),
                TextInput::make('customer_zipcode'),
                TextInput::make('customer_city'),
            ]);
    }
}
