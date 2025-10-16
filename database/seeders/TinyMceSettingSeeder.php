<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Setting;

class TinyMceSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Setting::updateOrCreate(
            ['key' => 'tinymce_api_key'],
            [
                'value' => '',
                'type' => 'text',
                'group' => 'tinymce',
            ]
        );
    }
}
