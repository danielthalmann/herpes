<?php

namespace Danielthalmann\Herpes\Models;

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
        'account_from_id',
        'account_to_id',
        'invoice_id',
        'accounting_text',
        'tax_code',
        'tax_rate',
        'tax_value',
        'debit',
        'credit',
    ];

    protected $attributes = [
        'date'              => null,
        'transaction_group' => null,
        'user_id'           => null,
        'user_name'         => null,
        'account_from_id'   => null,
        'account_to_id'     => null,
        'invoice_id'        => null,
        'accounting_text'   => null,
        'tax_code'          => null,
        'tax_rate'          => null,
        'tax_value'         => null,
        'debit'             => null,
        'credit'            => null,
    ];
}
