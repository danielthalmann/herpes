<?php

namespace Danielthalmann\Herpes\Models;

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
        'firstname',
        'street',
        'zipcode',
        'city',
    ];

    protected $attributes = [
        'company'    => null,
        'department' => null,
        'name'       => null,
        'firstname'  => null,
        'street'     => null,
        'zipcode'    => null,
        'city'       => null,
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
