<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\BlogPageSetting;

class BlogPageSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        BlogPageSetting::create([
            'background_image' => null,
            'overlay_type' => 'darken',
            'overlay_opacity' => 40,
            'background_position' => 'center center',
            'background_size' => 'cover',
            'title' => 'Блог о туях',
            'subtitle' => 'Полезные статьи по выращиванию, уходу и дизайну с туями',
            'is_active' => true,
        ]);
    }
}

