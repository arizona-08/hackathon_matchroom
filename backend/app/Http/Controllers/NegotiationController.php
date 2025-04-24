<?php

namespace App\Http\Controllers;

use App\Models\Negotiation;
use Illuminate\Http\Request;
use App\Models\Room;
use Illuminate\Support\Facades\DB;

class NegotiationController extends Controller
{
    public function index()
    {
        $userId = auth()->id();

        $latestNegotiations = DB::table('negotiations')
            ->select(DB::raw('MAX(id) as id'))
            ->where('user_id', $userId)
            ->groupBy('room_id');

        $negotiations = Negotiation::with(['room.hotel'])
            ->whereIn('id', $latestNegotiations->pluck('id'))
            ->get();

        return response()->json($negotiations);
    }

    public function roomHistory($roomId)
    {
        $negotiations = Negotiation::with('room.hotel')
            ->where('user_id', auth()->id())
            ->where('room_id', $roomId)
            ->orderBy('created_at')
            ->get();

        return response()->json($negotiations);
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'room_id' => 'required|exists:rooms,id',
            'proposed_price' => 'nullable|numeric|min:1',
        ]);

        $room = Room::findOrFail($request->room_id);
        $initialPrice = $room->price_per_night;

        $status = 'pending';
        $proposed = $request->proposed_price;

        if ($proposed) {
            $discount = 100 - (($proposed / $initialPrice) * 100);

            if ($discount >= $room->negotiation_max_discount) {
                $status = 'refused';
            } elseif ($discount <= $room->negotiation_auto_accept_threshold) {
                $status = 'accepted';
            } else {
                $status = 'proposed';
            }
        }

        $negotiation = Negotiation::create([
            'user_id' => $request->user_id,
            'room_id' => $request->room_id,
            'initial_price' => $initialPrice,
            'proposed_price' => $proposed,
            'status' => $status,
            'expires_at' => now()->addMinutes(180),
        ]);

        return response()->json($negotiation, 201);
    }


    public function proposePrice(Request $request, Negotiation $negotiation)
    {
        $request->validate([
            'proposed_price' => 'required|numeric|min:1',
        ]);

        $room = $negotiation->room;
        $proposed = $request->proposed_price;
        $initial = $negotiation->initial_price;

        $discount = 100 - (($proposed / $initial) * 100);

        if ($discount >= $room->negotiation_max_discount) {
            $status = 'refused';
        } elseif ($discount <= $room->negotiation_auto_accept_threshold) {
            $status = 'accepted';
        } else {
            $status = 'proposed';
        }

        $negotiation->proposed_price = $proposed;
        $negotiation->status = $status;
        $negotiation->save();

        return response()->json([
            'message' => 'Proposition enregistrée.',
            'negotiation' => $negotiation
        ]);
    }

    public function accept(Negotiation $negotiation)
    {
        if ($negotiation->expires_at && $negotiation->expires_at->isPast()) {
            return response()->json(['message' => 'La négociation a expiré.'], 410);
        }

        $negotiation->status = 'accepted';
        $negotiation->save();

        return response()->json(['message' => 'Proposition acceptée.', 'negotiation' => $negotiation]);
    }

    public function decline(Negotiation $negotiation)
    {
        if ($negotiation->expires_at && $negotiation->expires_at->isPast()) {
            return response()->json(['message' => 'La négociation a expiré.'], 410);
        }

        $negotiation->status = 'refused';
        $negotiation->save();

        return response()->json(['message' => 'Proposition refusée.', 'negotiation' => $negotiation]);
    }

    public function counter(Request $request, Negotiation $negotiation)
    {
        $request->validate([
            'counter_price' => 'required|numeric|min:1'
        ]);

        if ($negotiation->expires_at && $negotiation->expires_at->isPast()) {
            return response()->json(['message' => 'La négociation a expiré.'], 410);
        }

        $negotiation->proposed_price = $request->counter_price;
        $negotiation->status = 'countered';
        $negotiation->save();

        return response()->json(['message' => 'Contre-offre envoyée.', 'negotiation' => $negotiation]);
    }

    public function myNegotiations()
    {
        $user = auth()->user();

        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $negotiations = Negotiation::with(['room.hotel'])
            ->where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($negotiations);
    }
}
