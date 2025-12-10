<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResourceUsage extends Model
{
    use HasFactory;

    protected $table = 'resource_usages'; // or whatever your table name is

    protected $fillable = [
        'user_id',
        'water_liters',
        'fuel_liters',
        'total_usage'
    ];

    protected $casts = [
        'water_liters' => 'decimal:2',
        'fuel_liters'  => 'decimal:2',
        'total_usage'  => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}