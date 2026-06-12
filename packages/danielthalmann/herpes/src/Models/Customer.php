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

    protected static function booted(): void
    {
        static::deleting(function (Customer $customer) {
            /*
            seulement si le softdelete est aussi présent sur adresse
            $customer->addresses()->each(function (AddressCustomer $address) {
                $address->delete();
            });
            */
        });

    }

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
