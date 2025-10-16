<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\HomePageSectionTitle;

class HomePageSectionTitleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sections = [
            [
                'section_key' => 'products',
                'title' => 'Популярные сорта туи',
                'subtitle' => 'Широкий ассортимент саженцев и взрослых деревьев туи различных сортов для вашего сада',
                'is_active' => true,
                'order' => 1,
            ],
            [
                'section_key' => 'testimonials',
                'title' => 'Отзывы наших клиентов',
                'subtitle' => 'Мы гордимся отзывами наших покупателей. Качество наших растений и сервис — наш главный приоритет.',
                'is_active' => true,
                'order' => 2,
            ],
            [
                'section_key' => 'gallery',
                'title' => 'Следите за нами в Instagram',
                'subtitle' => 'Смотрите фото наших растений, примеры работ наших клиентов и полезные советы по уходу за туями в нашем Instagram',
                'is_active' => true,
                'order' => 3,
            ],
        ];

        foreach ($sections as $section) {
            HomePageSectionTitle::updateOrCreate(
                ['section_key' => $section['section_key']],
                $section
            );
        }
    }
}
