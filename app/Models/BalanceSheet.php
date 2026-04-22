<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;

class BalanceSheet extends Model
{
    use HasUlids;

    protected $fillable = [
        'balance_sheet_date'
    ];

}
