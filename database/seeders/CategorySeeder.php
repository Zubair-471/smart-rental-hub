<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Laptops',
                'description' => 'High-performance laptops for work and gaming',
                'image_url' => 'https://images.unsplash.com/photo-1531297484001-80022131f5a1?w=800',
                'slug' => 'laptops',
            ],
            [
                'name' => 'Cameras',
                'description' => 'Professional cameras for photography and videography',
                'image_url' => 'https://images.unsplash.com/photo-1516035069371-29a1b244cc32?w=800',
                'slug' => 'cameras',
            ],
            [
                'name' => 'Gaming Consoles',
                'description' => 'Latest gaming consoles and accessories',
                'image_url' => 'https://images.unsplash.com/photo-1486401899868-0e435ed85128?w=800',
                'slug' => 'gaming-consoles',
            ],
            [
                'name' => 'Drones',
                'description' => 'Professional drones for aerial photography and videography',
                'image_url' => 'https://images.unsplash.com/photo-1473968512647-3e447244af8f?w=800',
                'slug' => 'drones',
            ],
            [
                'name' => 'Audio Equipment',
                'description' => 'Professional audio equipment for events and production',
                'image_url' => 'https://images.unsplash.com/photo-1598653222000-6b7b7a552625?w=800',
                'slug' => 'audio-equipment',
            ],
            [
                'name' => 'VR Headsets',
                'description' => 'Virtual reality headsets for gaming and experiences',
                'image_url' => 'https://images.unsplash.com/photo-1622979135225-d2ba269cf1ac?w=800',
                'slug' => 'vr-headsets',
            ],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
} 