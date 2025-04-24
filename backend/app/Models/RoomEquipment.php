<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoomEquipment extends Model
{
    use HasFactory;

    protected $table = 'room_equipments';

    protected $fillable = [
        'room_id',
        'wifi', 'cuisine', 'lave_linge', 'seche_linge', 'climatisation',
        'chauffage', 'television', 'fer_a_repasser',
        'piscine', 'jacuzzi', 'parking', 'recharge_voiture', 'lit_bebe',
        'salle_de_sport', 'bord_de_mer', 'barbecue', 'petit_dejeuner',
        'diner', 'cheminee', 'fumeur',
        'acces_plain_pied', 'parking_pmr', 'entree_large', 'barre_soutien', 'siege_douche'
    ];

    public function room() {
        return $this->belongsTo(Room::class);
    }
}
