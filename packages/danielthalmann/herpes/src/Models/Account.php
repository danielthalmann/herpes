<?php

namespace Danielthalmann\Herpes\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    use HasUlids;

    protected $fillable = [
        'code',
        'name',
        'type',
    ];

    protected $attributes = [
        'code' => null,
        'name' => null,
        'type' => null,
    ];
}
