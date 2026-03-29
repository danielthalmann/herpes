<?php

namespace App\Filament\Resources\Invoices\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class InvoiceInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('id')
                    ->label('ID'),
                TextEntry::make('ref')
                    ->placeholder('-'),
                TextEntry::make('invoice_date')
                    ->date(),
                TextEntry::make('customer_id'),
                TextEntry::make('customer_company')
                    ->placeholder('-'),
                TextEntry::make('customer_department')
                    ->placeholder('-'),
                TextEntry::make('customer_name')
                    ->placeholder('-'),
                TextEntry::make('customer_street')
                    ->placeholder('-'),
                TextEntry::make('customer_zipcode')
                    ->placeholder('-'),
                TextEntry::make('customer_city')
                    ->placeholder('-'),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
