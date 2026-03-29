<?php

namespace App\Filament\Resources\Transactions\Pages;

use App\Filament\Resources\Transactions\TransactionResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;
use function Filament\Support\format_money;

class EditTransaction extends EditRecord
{
    protected static string $resource = TransactionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $data['debit'] = ($data['debit'] ? $data['debit'] / 100 : null);
        $data['credit'] = ($data['credit'] ? $data['credit'] / 100 : null);

        return $data;
    }

    protected function handleRecordUpdate(\Illuminate\Database\Eloquent\Model $record, array $data): \Illuminate\Database\Eloquent\Model
    {

        if ($data['date'] == null) {
            $data['date'] = \Carbon\Carbon::now()->startOfDay();
        }
        $data['debit'] = ($data['debit'] ? $data['debit'] * 100 : null);
        $data['credit'] = ($data['credit'] ? $data['credit'] * 100 : null);
        return parent::handleRecordUpdate($record, $data);
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
