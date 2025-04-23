<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Hotel extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'name', 'description', 'address',
        'latitude', 'longitude', 'type', 'rating_average'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function rooms() {
        return $this->hasMany(Room::class);
    }
}

