<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Device;
use Illuminate\Http\Request;

class DeviceController extends Controller
{
    public function index()
    {
        $devices = Device::with('category')
            ->when(request('category'), function($query, $category) {
                return $query->where('category_id', $category);
            })
            ->when(request('search'), function($query, $search) {
                return $query->where('name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            })
            ->paginate(10);

        return response()->json($devices);
    }

    public function show(Device $device)
    {
        return response()->json($device->load('category'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'daily_rate' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'image_url' => 'required|url',
            'specifications' => 'required|json',
            'status' => 'required|in:available,rented,maintenance',
            'condition' => 'required|string',
        ]);

        $device = Device::create($validated);

        return response()->json($device, 201);
    }

    public function update(Request $request, Device $device)
    {
        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'description' => 'sometimes|required|string',
            'daily_rate' => 'sometimes|required|numeric|min:0',
            'category_id' => 'sometimes|required|exists:categories,id',
            'image_url' => 'sometimes|required|url',
            'specifications' => 'sometimes|required|json',
            'status' => 'sometimes|required|in:available,rented,maintenance',
            'condition' => 'sometimes|required|string',
        ]);

        $device->update($validated);

        return response()->json($device);
    }

    public function destroy(Device $device)
    {
        $device->delete();
        return response()->json(null, 204);
    }
} 