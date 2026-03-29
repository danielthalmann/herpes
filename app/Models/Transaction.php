<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasUlids;
    protected $fillable = [
        'date',
        'transaction_group',
        'user_id',
        'user_name',
        'account_id',
        'account_text',
        'invoice_id',
        'accounting_text',
        'tax_code',
        'tax_rate',
        'tax_value',
        'debit',
        'credit',
    ];


}
