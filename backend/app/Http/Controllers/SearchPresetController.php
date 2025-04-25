<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SearchPreset;
use App\Models\Room;

class SearchPresetController extends Controller
{
    public function index()
    {
        return SearchPreset::where('user_id', auth()->id())->get();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'city' => 'nullable|string',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'min_price' => 'nullable|numeric|min:0',
            'max_price' => 'nullable|numeric|min:0',
            'people' => 'nullable|integer|min:1',
            'beds' => 'nullable|integer|min:1',
            'stars' => 'nullable|integer|min:0|max:5',
        ]);

        $filter = SearchPreset::create([
            ...$validated,
            'user_id' => auth()->id(),
        ]);

        return response()->json($filter, 201);
    }

    public function destroy(SearchPreset $searchFilter)
    {
        if ($searchFilter->user_id !== auth()->id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $searchFilter->delete();

        return response()->json(null, 204);
    }

    public function search(SearchPreset $preset)
    {
        $query = Room::with('hotel', 'equipment');

        if ($preset->city) {
            $query->whereHas('hotel', function ($q) use ($preset) {
                $q->whereRaw('LOWER(address) LIKE ?', ['%' . strtolower($preset->city) . '%']);
            });
        }

        if ($preset->stars) {
            $query->whereHas('hotel', function ($q) use ($preset) {
                $q->where('rating_average', '>=', $preset->stars);
            });
        }

        if ($preset->start_date && $preset->end_date) {
            $query->whereDate('available_from', '<=', $preset->start_date)
                  ->whereDate('available_to', '>=', $preset->end_date);
        }

        if ($preset->min_price) {
            $query->where('price_per_night', '>=', $preset->min_price);
        }

        if ($preset->max_price) {
            $query->where('price_per_night', '<=', $preset->max_price);
        }

        if ($preset->people) {
            $query->where('capacity', '>=', $preset->people);
        }

        if ($preset->beds) {
            $query->where('number_of_beds', '>=', $preset->beds);
        }

        $equipments = ['wifi', 'kitchen', 'washing_machine', 'dryer', 'air_conditioning', 'heating', 'tv', 'iron'];
        $extras = ['pool', 'jacuzzi', 'parking', 'car_charger', 'baby_bed', 'gym', 'seaside', 'barbecue', 'breakfast', 'dinner', 'fireplace', 'smoking'];
        $accessibility = ['ground_access', 'handicap_parking', 'wide_door', 'support_bar', 'shower_seat'];

        $allEquipment = array_merge($equipments, $extras, $accessibility);

        foreach ($allEquipment as $equipment) {
            if ($preset->$equipment) {
                $query->whereHas('equipment', function ($q) use ($equipment) {
                    $q->where($equipment, true);
                });
            }
        }

        $results = $query->get();

        return response()->json($results);
    }
}
