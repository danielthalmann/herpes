<?php

namespace App\Models;

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

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }

}
