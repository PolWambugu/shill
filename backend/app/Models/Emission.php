<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Emission extends Model
{
    protected $fillable = [
        'user_id', 'electricity_kwh', 'mileage_km', 'flights', 'total_co2', 'calculated_at'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}