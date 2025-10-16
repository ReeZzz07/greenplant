<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Туя западная',
                'slug' => 'tuya-zapadnaya',
                'description' => 'Самый распространенный вид туи. Отличается высокой морозостойкостью и неприхотливостью.',
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'name' => 'Саженцы туи',
                'slug' => 'sazhentsy-tui',
                'description' => 'Молодые саженцы туи различных сортов для самостоятельной высадки.',
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'name' => 'Взрослые деревья',
                'slug' => 'vzroslye-derevya',
                'description' => 'Взрослые деревья туи высотой от 1.5 метров для быстрого озеленения.',
                'is_active' => true,
                'sort_order' => 3,
            ],
            [
                'name' => 'Карликовые туи',
                'slug' => 'karlikovye-tui',
                'description' => 'Компактные сорта туи для небольших участков и альпийских горок.',
                'is_active' => true,
                'sort_order' => 4,
            ],
            [
                'name' => 'Для живой изгороди',
                'slug' => 'dlya-zhivoy-izgorodi',
                'description' => 'Лучшие сорта туи для создания живой изгороди.',
                'is_active' => true,
                'sort_order' => 5,
            ],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}

