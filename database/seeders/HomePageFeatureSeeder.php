<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\HomePageFeature;

class HomePageFeatureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $features = [
            [
                'icon' => 'flaticon-bag',
                'title' => 'Бесплатная доставка',
                'description' => 'Бесплатная доставка по Москве и области при заказе от 10000 рублей. Аккуратная транспортировка с сохранением корневой системы.',
                'order' => 1,
                'is_active' => true,
            ],
            [
                'icon' => 'flaticon-customer-service',
                'title' => 'Профессиональная поддержка',
                'description' => 'Наши специалисты помогут подобрать сорт туи, проконсультируют по посадке и уходу. Всегда на связи для ваших вопросов.',
                'order' => 2,
                'is_active' => true,
            ],
            [
                'icon' => 'flaticon-payment-security',
                'title' => 'Гарантия приживаемости',
                'description' => 'Все наши растения выращены в питомнике с соблюдением агротехники. Даем гарантию приживаемости при соблюдении рекомендаций.',
                'order' => 3,
                'is_active' => true,
            ],
        ];

        foreach ($features as $feature) {
            HomePageFeature::create($feature);
        }
    }
}
