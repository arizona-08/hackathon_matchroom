<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use App\Models\Room;

class MapDataController extends Controller
{
    public function index()
    {
        $hotels = Hotel::select('id', 'name', 'latitude', 'longitude', 'description')
            ->get()
            ->map(function ($hotel) {
                return [
                    'id' => $hotel->id,
                    'name' => $hotel->name,
                    'latitude' => $hotel->latitude,
                    'longitude' => $hotel->longitude,
                    'description' => $hotel->description,
                    'type' => 'hotel'
                ];
            });

        $rooms = Room::with('hotel')->get()->map(function ($room) {
            $hotel = $room->hotel;
            return [
                'id' => $room->id,
                'name' => $room->name,
                'latitude' => $hotel->latitude ?? null,
                'longitude' => $hotel->longitude ?? null,
                'description' => 'Capacité : ' . $room->capacity . ' | Prix : ' . number_format($room->price_per_night, 2) . '€ / nuit',
                'price_per_night' => $room->price_per_night, // 👈 ajouté ici
                'type' => 'room'
            ];  
        });

        return response()->json($hotels->concat($rooms));
    }
}
