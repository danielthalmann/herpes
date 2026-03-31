<?php

namespace App\Filament\Resources\Invoices\RelationManagers;

use App\Filament\Resources\Invoices\Resources\InvoiceItems\InvoiceItemResource;
use Filament\Actions\CreateAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Table;

class InvoiceItemRelationManager extends RelationManager
{
    protected static string $relationship = 'invoiceItems';

    protected static ?string $relatedResource = InvoiceItemResource::class;

    public function table(Table $table): Table
    {
        return $table
            ->headerActions([
                CreateAction::make(),
            ]);
    }
}
