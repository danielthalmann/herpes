<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;

class BalanceSheetItem extends Model
{
    use HasUlids;

    protected $fillable = [
        'balance_sheet_id',
        'balance_type',
        'description',
        'amount',
        'currency',
    ];

}
