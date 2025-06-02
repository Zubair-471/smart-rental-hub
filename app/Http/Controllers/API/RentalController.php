<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Rental;
use Illuminate\Http\Request;

class RentalController extends Controller
{
    public function index()
    {
        return Rental::with(['device', 'user'])->get();
    }

    public function store(Request $request)
    {
        $request->validate([
            'device_id' => 'required|exists:devices,id',
            'user_id' => 'required|exists:users,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'total_cost' => 'required|numeric',
        ]);

        $rental = Rental::create($request->all());

        return response()->json($rental, 201);
    }

    public function show($id)
    {
        $rental = Rental::with(['device', 'user'])->findOrFail($id);
        return response()->json($rental);
    }

    public function update(Request $request, $id)
    {
        $rental = Rental::findOrFail($id);

        $request->validate([
            'device_id' => 'sometimes|required|exists:devices,id',
            'user_id' => 'sometimes|required|exists:users,id',
            'start_date' => 'sometimes|required|date',
            'end_date' => 'sometimes|required|date|after_or_equal:start_date',
            'total_cost' => 'sometimes|required|numeric',
        ]);

        $rental->update($request->all());

        return response()->json($rental);
    }

    public function destroy($id)
    {
        $rental = Rental::findOrFail($id);
        $rental->delete();

        return response()->json(null, 204);
    }
}
