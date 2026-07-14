<?php

namespace Danielthalmann\Herpes\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;

class InvoiceItem extends Model
{
    use HasUlids;

    protected $fillable = [
        'id',
        'invoice_id',
        'no',
        'description',
        'quantity',
        'unit_price',
        'currency',
        'quantity_type',
    ];

    protected $attributes = [
        'no'            => null,
        'description'   => null,
        'quantity'      => null,
        'unit_price'    => null,
        'currency'      => 'CHF',
        'quantity_type' => null,
    ];

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }
}
