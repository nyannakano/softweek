<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypeSubscription extends Model
{
    protected $table = 'types_subscriptions';

    protected $fillable = [
        'price',
        'name',
        'description',
    ];
}
