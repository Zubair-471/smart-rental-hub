<?php

namespace App\Http\Controllers\Admin\Catalog;

use App\Http\Controllers\Controller;
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
    public function index()
    {
        $devices = Device::with('category')->latest()->paginate(10);
        $categories = Category::all();
        return view('admin.devices.index', compact('devices', 'categories'));
    }

    /**
     * Show the form for creating a new device.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $categories = Category::all();
        return view('admin.devices.create', compact('categories'));
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
            'deposit_amount' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:available,rented,maintenance',
            'condition' => 'required|in:new,good,fair,poor',
            'specifications' => 'nullable|string',
            'is_featured' => 'boolean',
        ]);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('devices', 'public');
            $validated['image_url'] = $imagePath;
        }

        $validated['is_featured'] = $request->has('is_featured');

        Device::create($validated);

        return redirect()->route('admin.devices.index')
            ->with('success', 'Device created successfully.');
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
        return view('admin.devices.edit', compact('device', 'categories'));
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
            'deposit_amount' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:available,rented,maintenance',
            'condition' => 'required|in:new,good,fair,poor',
            'specifications' => 'nullable|string',
            'is_featured' => 'boolean',
        ]);

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($device->image_url) {
                Storage::disk('public')->delete($device->image_url);
            }
            $imagePath = $request->file('image')->store('devices', 'public');
            $validated['image_url'] = $imagePath;
        }

        $validated['is_featured'] = $request->has('is_featured');

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
        if ($device->image_url) {
            Storage::disk('public')->delete($device->image_url);
        }

        $device->delete();

        return redirect()->route('admin.devices.index')
            ->with('success', 'Device deleted successfully.');
    }
} 