<?php

namespace App\Filament\Resources\Customers\Resources\AddressCustomers\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class AddressCustomersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                /*
                TextColumn::make('customer_id')
                    ->numeric()
                    ->sortable(),
                    */
                TextColumn::make('company')
                    ->searchable(),
                TextColumn::make('department')
                    ->searchable(),
                TextColumn::make('name')
                    ->searchable(),
                TextColumn::make('street')
                    ->searchable(),
                TextColumn::make('zipcode')
                    ->searchable(),
                TextColumn::make('city')
                    ->searchable(),
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
