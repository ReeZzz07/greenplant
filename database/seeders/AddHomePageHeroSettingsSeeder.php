<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AddHomePageHeroSettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\HeroSetting::create([
            'background_image' => null,
            'background_position' => 'center center',
            'background_size' => 'cover',
            'overlay_type' => 'darken',
            'overlay_opacity' => 40,
            'background_color' => '#2c5f2d',
            'is_active' => true,
        ]);
    }
}
