<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $fillable = [
        'code',
        'percentage',
        'uses',
        'max_uses',
    ];

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }
}
