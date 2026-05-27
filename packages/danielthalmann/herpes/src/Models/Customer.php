<?php

namespace Danielthalmann\Herpes\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use HasUlids;
    use SoftDeletes;

    protected $fillable = ['name'];

    /**
     * Get all of the Address for the Customer
     */
    public function addressCustomers(): HasMany
    {
        return $this->hasMany(AddressCustomer::class);
    }

    /**
     * Get all of the Address for the Customer
     */
    public function addresses(): HasMany
    {
        return $this->hasMany(AddressCustomer::class);
    }

}
