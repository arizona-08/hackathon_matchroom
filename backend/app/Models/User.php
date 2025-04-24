<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Favorite;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;

    protected $fillable = [
        'name',
        'firstname',
        'email',
        'password',
        'type',
        'photo_path',
        'hotel_access_key', // ✅ ajouté ici
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'hotel_access_key', // ✅ caché dans les réponses
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }


    public function hotel(){
        return $this->hasOne(Hotel::class);
    }

}
