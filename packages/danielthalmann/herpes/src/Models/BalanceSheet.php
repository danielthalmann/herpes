<?php

namespace Danielthalmann\Herpes\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;

class BalanceSheet extends Model
{
    use HasUlids;

    protected $fillable = [
        'balance_sheet_date',
    ];

    protected $attributes = [
        'balance_sheet_date' => null,
    ];
}
