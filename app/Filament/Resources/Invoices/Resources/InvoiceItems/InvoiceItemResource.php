<?php

namespace App\Filament\Resources\Invoices\Resources\InvoiceItems;

use App\Filament\Resources\Invoices\InvoiceResource;
use App\Filament\Resources\Invoices\Resources\InvoiceItems\Pages\CreateInvoiceItem;
use App\Filament\Resources\Invoices\Resources\InvoiceItems\Pages\EditInvoiceItem;
use App\Filament\Resources\Invoices\Resources\InvoiceItems\Pages\ViewInvoiceItem;
use App\Filament\Resources\Invoices\Resources\InvoiceItems\Schemas\InvoiceItemForm;
use App\Filament\Resources\Invoices\Resources\InvoiceItems\Schemas\InvoiceItemInfolist;
use App\Filament\Resources\Invoices\Resources\InvoiceItems\Tables\InvoiceItemsTable;
use App\Models\InvoiceItem;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class InvoiceItemResource extends Resource
{
    protected static ?string $model = InvoiceItem::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $parentResource = InvoiceResource::class;

    public static function form(Schema $schema): Schema
    {
        return InvoiceItemForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return InvoiceItemInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return InvoiceItemsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'create' => CreateInvoiceItem::route('/create'),
            'view' => ViewInvoiceItem::route('/{record}'),
            'edit' => EditInvoiceItem::route('/{record}/edit'),
        ];
    }
}
