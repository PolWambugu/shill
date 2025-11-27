<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ResourceUsage extends Model
{
    protected $fillable = [
        'user_id', 'water_liters', 'fuel_liters', 'recorded_at'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}