<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;

class AddressCustomer extends Model
{
    use HasUlids;
    protected $fillable = [
        'customer_id',
        'company',
        'department',
        'name',
        'street',
        'zipcode',
        'city',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
