<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\HomePageGallery;

class HomePageGallerySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $galleries = [
            [
                'image' => 'assets/images/product-1.jpg',
                'link' => 'https://instagram.com/greenplant',
                'order' => 1,
                'is_active' => true,
            ],
            [
                'image' => 'assets/images/product-2.jpg',
                'link' => 'https://instagram.com/greenplant',
                'order' => 2,
                'is_active' => true,
            ],
            [
                'image' => 'assets/images/product-3.jpg',
                'link' => 'https://instagram.com/greenplant',
                'order' => 3,
                'is_active' => true,
            ],
            [
                'image' => 'assets/images/product-4.jpg',
                'link' => 'https://instagram.com/greenplant',
                'order' => 4,
                'is_active' => true,
            ],
            [
                'image' => 'assets/images/product-5.jpg',
                'link' => 'https://instagram.com/greenplant',
                'order' => 5,
                'is_active' => true,
            ],
            [
                'image' => 'assets/images/product-6.jpg',
                'link' => 'https://instagram.com/greenplant',
                'order' => 6,
                'is_active' => true,
            ],
        ];

        foreach ($galleries as $gallery) {
            HomePageGallery::create($gallery);
        }
    }
}

