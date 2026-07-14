<?php

namespace Danielthalmann\Herpes\Models;

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

    protected $attributes = [
        'ref' => null,
        'invoice_date' => null,
        'customer_company' => null,
        'customer_department' => null,
        'customer_id' => null,
        'customer_name' => null,
        'customer_street' => null,
        'customer_zipcode' => null,
        'customer_city' => null,
    ];

    //alias
    public function invoiceItems(): HasMany
    {
        return $this->hasMany(InvoiceItem::class);
    }
}
