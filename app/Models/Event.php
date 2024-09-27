<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Event extends Model
{
    use SoftDeletes;

    public $timestamps = false;

    protected $fillable = [
        'day_id',
        'title',
        'company',
    ];

    public function day(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Day::class);
    }

    public function subscriptions(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Subscription::class, 'subscriptions_events');
    }
}
