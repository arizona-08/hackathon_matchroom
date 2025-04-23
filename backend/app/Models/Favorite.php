<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'room_id',
    ];

    public function user()
    {
        return $this->hasMany(User::class);
    }

    public function room()
    {
        return $this->hasMany(Room::class);
    }
}

