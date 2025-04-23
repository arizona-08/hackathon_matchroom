<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Room extends Model
{
    use HasFactory;

    protected $fillable = [
        'hotel_id', 'name', 'type', 'capacity', 'price_per_night',
        'available_from', 'available_to', 'equipment', 'score_matching'
    ];

    protected $casts = [
        'equipment' => 'array',
        'available_from' => 'date',
        'available_to' => 'date'
    ];

    public function hotel() {
        return $this->belongsTo(Hotel::class);
    }
}

