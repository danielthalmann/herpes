<?php

namespace App\Models;

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
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function addressCustomers(): HasMany
    {
        return $this->hasMany(AddressCustomer::class);
    }

    // alias
    public function addresses(): HasMany
    {
        return $this->addressCustomers();
    }
}
