<?php

namespace App\Http\Controllers;

use App\Models\Device;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DeviceController extends Controller
{
    /**
     * Display a listing of the devices.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $query = Device::query();

        // Apply category filter
        if ($request->has('category')) {
            $query->where('category_id', $request->category);
        }

        // Apply search filter
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Apply sorting
        switch ($request->sort) {
            case 'price_low':
                $query->orderBy('daily_rate', 'asc');
                break;
            case 'price_high':
                $query->orderBy('daily_rate', 'desc');
                break;
            default:
                $query->latest();
                break;
        }

        $devices = $query->with('category')->paginate(9);
        $categories = Category::all();

        return view('devices.index', compact('devices', 'categories'));
    }

    /**
     * Show the form for creating a new device.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $categories = Category::all();
        return view('devices.create', compact('categories'));
    }

    /**
     * Store a newly created device in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'daily_rate' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:available,rented,maintenance',
            'condition' => 'required|in:new,good,fair,poor',
            'specifications' => 'nullable|string',
        ]);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('devices', 'public');
            $validated['image'] = $imagePath;
        }

        Device::create($validated);

        return redirect()->route('admin.devices.index')
            ->with('success', 'Device created successfully.');
    }

    /**
     * Display the specified device.
     *
     * @param  \App\Models\Device  $device
     * @return \Illuminate\View\View
     */
    public function show(Device $device)
    {
        $device->load(['category', 'reviews.user']);
        return view('devices.show', compact('device'));
    }

    /**
     * Show the form for editing the specified device.
     *
     * @param  \App\Models\Device  $device
     * @return \Illuminate\View\View
     */
    public function edit(Device $device)
    {
        $categories = Category::all();
        return view('devices.edit', compact('device', 'categories'));
    }

    /**
     * Update the specified device in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Device  $device
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Device $device)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'daily_rate' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:available,rented,maintenance',
            'condition' => 'required|in:new,good,fair,poor',
            'specifications' => 'nullable|string',
        ]);

        if ($request->hasFile('image')) {
            if ($device->image) {
                Storage::disk('public')->delete($device->image);
            }
            $imagePath = $request->file('image')->store('devices', 'public');
            $validated['image'] = $imagePath;
        }

        $device->update($validated);

        return redirect()->route('admin.devices.index')
            ->with('success', 'Device updated successfully.');
    }

    /**
     * Remove the specified device from storage.
     *
     * @param  \App\Models\Device  $device
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Device $device)
    {
        // Delete image if exists
        if ($device->image) {
            Storage::disk('public')->delete($device->image);
        }

        $device->delete();

        return redirect()->route('admin.devices.index')
            ->with('success', 'Device deleted successfully.');
    }
}
