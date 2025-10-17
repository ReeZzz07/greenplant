<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\AccountPageSetting;

class AccountPageSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        AccountPageSetting::create([
            'hero_background_image' => null,
            'overlay_type' => 'darken',
            'overlay_opacity' => 40,
            'background_position' => 'center center',
            'background_size' => 'cover',
        ]);
    }
}

