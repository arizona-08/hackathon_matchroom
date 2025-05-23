<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use App\Models\Room;
use App\Models\RoomImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RoomController extends Controller
{
    public function index()
    {
        return response()->json([
            "rooms" => Room::with('hotel', 'images')->get()
        ]);
    }

    public function getRoomsFromHotel(Hotel $hotel){
        $rooms = Room::where('hotel_id', $hotel->id)->with('images', 'hotel')->get();
        return response()->json([
            "rooms" => $rooms
        ]);
    }


    public function store(Request $request)
    {
        // $room = Room::create($request->all());
        $user = $request->user();
        $user->load('hotel');

        $request->validate([
            'photo_path' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $path = null;
        if ($request->hasFile('photo_path')) {
            $path = $request->file('photo_path')->store('uploads/rooms', 'public');
        }

        $hotel_id = $user->hotel->id;

        $room = Room::create([
            'hotel_id' => $hotel_id,
            'name' => $request->name,
            'description' => $request->description,
            'price_per_night' => $request->price,
            'capacity' => $request->capacity,
            'available_from' => $request->available_from,
            'available_to' => $request->available_to,
            'equipment' => $request->equipment,
            'score_matching' => $request->score_matching,
            'photo_path' => $path,
            'number_of_beds' => $request->number_of_beds,
            'negotiation_max_discount' => $request->negotiation_max_discount,
            'negotiation_auto_accept_threshold' => $request->negotiation_auto_accept_threshold,
        ]);

        $room->save();

        if ($request->hasFile('complementary_imgs')) {
            foreach ($request->file('complementary_imgs') as $file) {
                $roomImage = new RoomImage();
                $roomImage->room_id = $room->id;
                $roomImage->image_url = $file->store('uploads/rooms/' . $room->id, 'public');
                $roomImage->save();
            }
        }
        return response()->json($room, 201);
    }

    public function show(Room $room)
    {
        $room->load('hotel', 'images');
        return response()->json([
            "room" => $room
        ]);
    }

    public function showSimple(Room $room){
        return response()->json([
            "room" => $room
        ]);
    }

    public function update(Request $request, Room $room)
    {
        $user = $request->user();
        $user->load('hotel');

        $hotel_id = $user->hotel->id;

        $room->update([
            'hotel_id' => $hotel_id,
            'name' => $request->name,
            'description' => $request->description,
            'price_per_night' => $request->price_per_night,
            'capacity' => $request->capacity,
            'available_from' => $request->available_from,
            'available_to' => $request->available_to,
            'equipment' => $request->equipment,
            'score_matching' => $request->score_matching,
            'number_of_beds' => $request->number_of_beds,
            'negotiation_max_discount' => $request->negotiation_max_discount,
            'negotiation_auto_accept_threshold' => $request->negotiation_auto_accept_threshold,
        ]);

        $room->save();

        return response()->json($room, 201);
    }

    public function updateWithPic(Request $request, Room $room){
        $user = $request->user();
        $user->load('hotel');

        $path = null;
        if ($request->hasFile('photo_path')) {
            $request->validate([
                'photo_path' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            //faire en sorte de supprimer l'ancienne image

            $path = $request->file('photo_path')->store('uploads/rooms', 'public');
            $room->photo_path = $path;
            $room->save();
            return response()->json($room, 201);
        } else {
            return response()->json([
                'error' => 'No file uploaded',
                'request' => $request->all()
            ], 400);
        }
    }

    public function destroy(Room $room)
    {
        if($room){
            $room->delete();
            return response()->json([
                'message' => 'Chambre supprimée avec succès'
            ], 204);
        }
        
    }
}
