<?php

namespace App\Filament\Resources\Transactions\Pages;

use App\Filament\Resources\Transactions\TransactionResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class CreateTransaction extends CreateRecord
{
    protected static string $resource = TransactionResource::class;

    protected function handleRecordCreation(array $data): Model
    {

        $data['user_id'] = Auth::user()->id;
        $data['user_name'] = Auth::user()->name;
        if ($data['date'] == null) {
            $data['date'] = \Carbon\Carbon::now()->startOfDay();
        }
        $data['debit'] = ($data['debit'] ? $data['debit'] * 100 : null);
        $data['credit'] = ($data['credit'] ? $data['credit'] * 100 : null);

        return parent::handleRecordCreation($data);
    }
    protected function getRedirectUrl(): string
    {
        return $this->previousUrl ?? $this->getResource()::getUrl('index');
    }
}
