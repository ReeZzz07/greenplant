<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ContactPageSetting;

class ContactPageSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ContactPageSetting::create([
            'background_image' => null,
            'overlay_type' => 'darken',
            'overlay_opacity' => 40,
            'background_position' => 'center center',
            'background_size' => 'cover',
            'title' => 'Свяжитесь с нами',
            'subtitle' => 'Будем рады ответить на ваши вопросы и помочь с выбором растений',
            'map_latitude' => '55.751244',
            'map_longitude' => '37.618423',
            'map_zoom' => 12,
            'map_description' => 'Питомник GreenPlant',
            'is_active' => true,
        ]);
    }
}

