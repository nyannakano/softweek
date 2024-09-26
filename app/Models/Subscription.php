<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    protected $table = 'subscriptions';

    protected $fillable = [
        'user_id',
        'payment_id',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
