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
        'role',
        'photo_path',
        'hotel_access_key',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'hotel_access_key',
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

    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isHotelier()
    {
        return $this->role === 'hotelier';
    }

    public function isClient()
    {
        return $this->role === 'client';
    }

}
