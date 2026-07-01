<?php

namespace Danielthalmann\Herpes\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasUlids;

    protected $fillable = [
        'type',
        'status',
        'summary',
        'description',
        'customer_id',
        'parent_id',
        'reporter_id',
        'assignee_id',
        'times',
        'eval_times',
        'invoice',
        'invoiced_at',
    ];

    protected $attributes = [
        'type' => null,
        'status' => null,
        'summary' => null,
        'description' => null,
        'customer_id' => null,
        'parent_id' => null,
        'reporter_id' => null,
        'assignee_id' => null,
        'times' => null,
        'eval_times' => null,
        'invoice' => false,
        'invoiced_at' => null,
    ];
}
