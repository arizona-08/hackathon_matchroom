<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\RoomImage;
use App\Models\Favorite;
use App\Models\RoomEquipment;


class Room extends Model
{
    use HasFactory;

    protected $fillable = [
        'hotel_id', 'name','capacity', 'price_per_night', 'description',
        'available_from', 'available_to', 'equipment', 'score_matching', 'negotiation_max_discount',
        'negotiation_auto_accept_threshold', 'photo_path', 'number_of_beds'
    ];

    protected $casts = [
        'equipment' => 'array',
        'available_from' => 'date',
        'available_to' => 'date'
    ];

    protected $appends = ['photo_url'];

    public function hotel() {
        return $this->belongsTo(Hotel::class);
    }

    public function images()
    {
        return $this->hasMany(RoomImage::class);
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

    public function equipment()
    {
        return $this->hasOne(RoomEquipment::class);
    }

    public function getPhotoUrlAttribute()
    {
        return $this->photo_path
            ? asset('storage/' . $this->photo_path)
            : null;
    }
}

