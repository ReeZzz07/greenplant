<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Slider;

class SliderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sliders = [
            [
                'title' => 'Добро пожаловать в Green Plant',
                'subtitle' => 'Саженцы туи для вашего сада',
                'description' => 'Широкий ассортимент качественных саженцев туи различных сортов. Выращиваем с любовью для вашего идеального сада.',
                'button_text' => 'Смотреть каталог',
                'button_link' => '/catalog',
                'image' => null,
                'order' => 1,
                'is_active' => true,
                'image_position_x' => 50,
                'image_position_y' => 50,
            ],
            [
                'title' => 'Качественные растения',
                'subtitle' => 'Из собственного питомника',
                'description' => 'Все наши растения выращены в питомнике с соблюдением агротехники. Гарантируем приживаемость и здоровье растений.',
                'button_text' => 'Узнать больше',
                'button_link' => '/about',
                'image' => null,
                'order' => 2,
                'is_active' => true,
                'image_position_x' => 50,
                'image_position_y' => 50,
            ],
        ];

        foreach ($sliders as $slider) {
            Slider::create($slider);
        }
    }
}

