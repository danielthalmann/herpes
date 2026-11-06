<?php

namespace Danielthalmann\Herpes\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Timesheet extends Model
{
    use HasUlids;
    use SoftDeletes;

    protected $fillable = [
        'ticket_id',
        'start',
        'end',
        'comment',
    ];

    protected $attributes = [
        'ticket_id' => null,
        'start' => null,
        'end' => null,
        'comment' => null,
    ];
}
