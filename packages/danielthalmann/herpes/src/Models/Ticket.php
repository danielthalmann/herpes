<?php

namespace Danielthalmann\Herpes\Models;

use Danielthalmann\Herpes\Models\Customer;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ticket extends Model
{
    use HasUlids;
    use SoftDeletes;

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

    // overwriting the model boot method to extend it with a addition to the deleting event
    public static function boot()
    {
        parent::boot();
        static::deleting(function($ticket) {
            $ticket->timesheets->each(function($timesheet){
                $timesheet->delete();
            });
        });
    }

    public function timesheets(): HasMany
    {
        return $this->hasMany(Timesheet::class);
    }

    public function assignee(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'assignee_id');
    } 

    public function customer(): HasOne
    {
        return $this->hasOne(Customer::class, 'id', 'customer_id');
    } 

    public function parent(): HasOne
    {
        return $this->hasOne(Ticket::class, 'id', 'parent_id');
    } 


}
