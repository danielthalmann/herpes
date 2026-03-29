<?php

namespace App\Filament\Resources\Transactions\Tables;

use App\Models\Account;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\TextInputColumn;
use Filament\Tables\Table;

class TransactionsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('date')
                    ->date('d.m.Y')
                    ->sortable(),
                    /*
                TextColumn::make('transaction_group')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('user_id')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('user_name')
                    ->searchable(),
                TextColumn::make('account_id')
                    ->numeric()
                    ->sortable(),
                    */
                SelectColumn::make('account_id')
                    ->label('Account')
                    ->options(Account::query()->pluck('name', 'id'))
                    ->searchableOptions()
                        ,
                TextColumn::make('invoice_id')
                    ->numeric()
                    ->sortable(),
                TextInputColumn::make('accounting_text')
                    ->searchable(),
                    /*
                TextColumn::make('tax_code')
                    ->searchable(),
                TextColumn::make('tax_rate')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('tax_value')
                    ->numeric()
                    ->sortable(),
                    */
                TextColumn::make('debit')
                    ->money('CHF', divideBy: 100, locale: 'ch')
                    ->sortable(),
                TextColumn::make('credit')
                    ->money('CHF', divideBy: 100, locale: 'ch')
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
