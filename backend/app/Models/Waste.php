<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Waste extends Model
{
    protected $fillable = [
        'user_id', 'plastic_kg', 'paper_kg', 'organic_kg', 'recorded_at'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}