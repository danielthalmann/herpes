<?php

namespace App\Filament\Resources\Transactions\Schemas;

use App\Models\Account;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\SelectColumn;

class TransactionForm
{
    public static function configure(Schema $schema): Schema
    {



        return $schema
            ->components([

                DatePicker::make('date'),
                /*
                TextInput::make('transaction_group')
                    ->numeric(),
                TextInput::make('user_id')
                    ->numeric(),
                TextInput::make('user_name'),

                TextInput::make('account_id')
                    ->numeric(),
                */
                Select::make('account_id')
                    ->label('Account')
                    ->options(Account::query()->pluck('name', 'id'))
                    ->searchable()
                        ,
                /*
                SelectColumn::make('account_id')
                    ->searchableOptions()
                    ->getOptionsSearchResultsUsing(fn (string $search): array => Account::query()
                        ->where('name', 'like', "%{$search}%")
                        ->limit(50)
                        ->pluck('name', 'id')
                        ->all())
                    ->getOptionLabelUsing(fn ($value): ?string => Account::find($value)?->name),
                    TextInput::make('account_text'),
                */
                TextInput::make('invoice_id')
                    ->numeric(),

                Textarea::make('accounting_text'),
                /*
                TextInput::make('tax_code'),
                TextInput::make('tax_rate')
                    ->numeric(),
                TextInput::make('tax_value')
                    ->numeric(),
                */
                TextInput::make('debit')
                    ->type('money')
                    ->numeric(),
                TextInput::make('credit')
                    ->type('money')
                    ->numeric(),


            ]);
    }
}
