<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\CatalogPageSetting;

class CatalogPageSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        CatalogPageSetting::create([
            'background_image' => null,
            'overlay_type' => 'darken',
            'overlay_opacity' => 40,
            'background_position' => 'center center',
            'background_size' => 'cover',
            'title' => 'Каталог туй',
            'subtitle' => 'Широкий ассортимент саженцев туи различных сортов и размеров для вашего сада',
            'is_active' => true,
        ]);
    }
}

