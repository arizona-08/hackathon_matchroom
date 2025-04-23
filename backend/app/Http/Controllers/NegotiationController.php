<?php

namespace App\Http\Controllers;

use App\Models\Negotiation;
use Illuminate\Http\Request;
use App\Models\Room;

class NegotiationController extends Controller
{
    public function index()
    {
        return Negotiation::with(['user', 'room'])->get();
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'room_id' => 'required|exists:rooms,id',
            'proposed_price' => 'required|numeric|min:1',
        ]);

        $room = Room::findOrFail($request->room_id);
        $initialPrice = $room->price_per_night;
        $proposed = $request->proposed_price;

        $discount = 100 - (($proposed / $initialPrice) * 100);

        if ($discount >= $room->negotiation_max_discount) {
            $status = 'refused';
        } elseif ($discount <= $room->negotiation_auto_accept_threshold) {
            $status = 'accepted';
        } else {
            $status = 'proposed';
        }

        $negotiation = Negotiation::create([
            'user_id' => $request->user_id,
            'room_id' => $request->room_id,
            'initial_price' => $initialPrice,
            'proposed_price' => $proposed,
            'status' => $status,
        ]);

        return response()->json($negotiation, 201);
    }

    public function accept(Negotiation $negotiation)
    {
        $negotiation->status = 'accepted';
        $negotiation->save();

        return response()->json(['message' => 'Proposition acceptée.', 'negotiation' => $negotiation]);
    }

    public function decline(Negotiation $negotiation)
    {
        $negotiation->status = 'refused';
        $negotiation->save();

        return response()->json(['message' => 'Proposition refusée.', 'negotiation' => $negotiation]);
    }

    public function counter(Request $request, Negotiation $negotiation)
    {
        $request->validate([
            'counter_price' => 'required|numeric|min:1'
        ]);

        $negotiation->proposed_price = $request->counter_price;
        $negotiation->status = 'countered';
        $negotiation->save();

        return response()->json(['message' => 'Contre-offre envoyée.', 'negotiation' => $negotiation]);
    }
}

