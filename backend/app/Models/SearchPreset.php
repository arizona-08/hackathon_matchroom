<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class searchPreset extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'city',
        'start_date',
        'end_date',
        'min_price',
        'max_price',
        'capacity',
        'beds',
        'stars_min',
        'equipment_filters',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'equipment_filters' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
