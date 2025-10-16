<?php

namespace Database\Seeders;

use App\Models\Testimonial;
use Illuminate\Database\Seeder;

class TestimonialSeeder extends Seeder
{
    public function run(): void
    {
        $testimonials = [
            [
                'name' => 'Алексей Иванов',
                'position' => 'Владелец частного дома',
                'content' => 'Заказывали туи Смарагд для живой изгороди. Все растения здоровые, хорошо прижились. Спасибо за консультацию по посадке!',
                'rating' => 5,
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'name' => 'Мария Петрова',
                'position' => 'Ландшафтный дизайнер',
                'content' => 'Отличный питомник! Купили взрослые деревья Брабант. Доставка вовремя, посадка аккуратная. Рекомендую!',
                'rating' => 5,
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'name' => 'Дмитрий Соколов',
                'position' => 'Руководитель строительной компании',
                'content' => 'Покупали оптом саженцы для благоустройства территории. Цены приятные, качество на высоте. Будем обращаться еще!',
                'rating' => 5,
                'is_active' => true,
                'sort_order' => 3,
            ],
            [
                'name' => 'Елена Морозова',
                'position' => 'Садовод-любитель',
                'content' => 'Очень довольны покупкой! Туи пришли с закрытой корневой системой, все прижились на 100%. Качество отличное!',
                'rating' => 5,
                'is_active' => true,
                'sort_order' => 4,
            ],
            [
                'name' => 'Игорь Васильев',
                'position' => 'Управляющий ТСЖ',
                'content' => 'Заказывали большую партию саженцев. Индивидуальный подход, отличные цены, все сделали быстро. Молодцы!',
                'rating' => 5,
                'is_active' => true,
                'sort_order' => 5,
            ],
        ];

        foreach ($testimonials as $testimonial) {
            Testimonial::create($testimonial);
        }
    }
}

