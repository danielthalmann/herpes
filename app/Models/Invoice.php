<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Invoice extends Model
{
    use HasUlids;

    protected $fillable = [
        'ref',
        'invoice_date',
        'customer_id',
        'customer_company',
        'customer_department',
        'customer_name',
        'customer_street',
        'customer_zipcode',
        'customer_city',
    ];

    //alias
    public function invoiceItems(): HasMany
    {
        return $this->hasMany(InvoiceItem::class);
    }
}
