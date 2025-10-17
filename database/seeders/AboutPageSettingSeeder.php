<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\AboutPageSetting;

class AboutPageSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        AboutPageSetting::create([
            'background_image' => null,
            'overlay_type' => 'darken',
            'overlay_opacity' => 40,
            'background_position' => 'center center',
            'background_size' => 'cover',
            'title' => 'О компании GreenPlant',
            'subtitle' => 'Выращиваем здоровые растения с любовью к природе',
            'main_content' => '<p>Питомник GreenPlant специализируется на выращивании туй различных сортов. Мы занимаемся этим уже более 10 лет и знаем всё о правильном уходе за этими прекрасными растениями.</p><p>Все наши саженцы выращены с соблюдением агротехники, регулярно удобряются и обрабатываются от вредителей. Мы гарантируем высокое качество посадочного материала и приживаемость растений.</p>',
            'about_image' => null,
            'welcome_title' => 'Добро пожаловать в GreenPlant',
            'welcome_text' => 'Мы рады приветствовать вас в нашем питомнике! Здесь вы найдете туи на любой вкус - от компактных сортов для небольших участков до величественных деревьев для создания живых изгородей.',
            'is_active' => true,
        ]);
    }
}

