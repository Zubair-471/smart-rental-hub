<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('devices')->get();
        return response()->json($categories);
    }

    public function show(Category $category)
    {
        return response()->json($category->load('devices'));
    }

    public function devices(Category $category)
    {
        $devices = $category->devices()->paginate(10);
        return response()->json($devices);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories',
            'description' => 'required|string',
            'icon' => 'required|string',
        ]);

        $category = Category::create($validated);

        return response()->json($category, 201);
    }

    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255|unique:categories,name,' . $category->id,
            'description' => 'sometimes|required|string',
            'icon' => 'sometimes|required|string',
        ]);

        $category->update($validated);

        return response()->json($category);
    }

    public function destroy(Category $category)
    {
        if ($category->devices()->exists()) {
            return response()->json([
                'message' => 'Cannot delete category with associated devices'
            ], 422);
        }

        $category->delete();
        return response()->json(null, 204);
    }
} 