<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Emissions extends Model   // ← MUST BE Emissions (singular/plural doesn't matter, but NOT Controller)
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'electricity_kwh',
        'mileage_km',
        'flights',
        'total_co2'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}