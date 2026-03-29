<?php

namespace App\Filament\Resources\Transactions\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class TransactionInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('date')
                    ->date('d.m.Y')
                    ->placeholder('-'),
                TextEntry::make('transaction_group')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('user_id')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('user_name')
                    ->placeholder('-'),
                TextEntry::make('account_id')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('account_text')
                    ->placeholder('-'),
                TextEntry::make('invoice_id')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('accounting_text')
                    ->placeholder('-'),
                TextEntry::make('tax_code')
                    ->placeholder('-'),
                TextEntry::make('tax_rate')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('tax_value')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('debit')
                    ->money('CHF', divideBy: 100, locale: 'ch')
                    ->placeholder('-'),
                TextEntry::make('credit')
                    ->money('CHF', divideBy: 100, locale: 'ch')
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
