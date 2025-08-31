<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Configuration extends Model
{
    protected $table = 'configurations';

    protected $fillable = [
        'opening_day_id',
        'happy_hour_day_id',
        ];

    public function openingDay(): BelongsTo
    {
        return $this->belongsTo(Day::class, 'opening_day_id');
    }

    public function happyHourDay(): BelongsTo
    {
        return $this->belongsTo(Day::class, 'happy_hour_day_id');
    }
}
