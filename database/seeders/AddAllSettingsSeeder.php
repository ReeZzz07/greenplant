<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class AddAllSettingsSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            // Основные настройки
            ['key' => 'site_keywords', 'value' => 'туя, саженцы туи, купить тую, туя западная, живая изгородь, питомник растений, GreenPlant', 'type' => 'textarea', 'group' => 'general'],
            ['key' => 'site_author', 'value' => 'GreenPlant', 'type' => 'text', 'group' => 'general'],
            
            // Контактная информация
            ['key' => 'admin_email', 'value' => 'admin@greenplant.ru', 'type' => 'email', 'group' => 'contacts'],
            
            // Настройки доставки
            ['key' => 'delivery_cost', 'value' => '500', 'type' => 'number', 'group' => 'delivery'],
            
            // SEO и аналитика
            ['key' => 'google_analytics_id', 'value' => '', 'type' => 'text', 'group' => 'seo'],
            ['key' => 'yandex_metrika_id', 'value' => '', 'type' => 'text', 'group' => 'seo'],
            ['key' => 'google_tag_manager_id', 'value' => '', 'type' => 'text', 'group' => 'seo'],
            
            // Интеграции
            ['key' => 'google_maps_api_key', 'value' => '', 'type' => 'text', 'group' => 'integrations'],
            ['key' => 'yandex_maps_api_key', 'value' => '', 'type' => 'text', 'group' => 'integrations'],
            
            // Юридическая информация
            ['key' => 'company_inn', 'value' => '', 'type' => 'text', 'group' => 'legal'],
            ['key' => 'company_ogrn', 'value' => '', 'type' => 'text', 'group' => 'legal'],
            ['key' => 'company_legal_address', 'value' => '', 'type' => 'textarea', 'group' => 'legal'],
            ['key' => 'company_bank_details', 'value' => '', 'type' => 'textarea', 'group' => 'legal'],
            
            // Настройки каталога
            ['key' => 'products_per_page', 'value' => '12', 'type' => 'number', 'group' => 'catalog'],
            ['key' => 'show_stock', 'value' => '1', 'type' => 'checkbox', 'group' => 'catalog'],
            ['key' => 'show_prices', 'value' => '1', 'type' => 'checkbox', 'group' => 'catalog'],
            ['key' => 'min_order_amount', 'value' => '0', 'type' => 'number', 'group' => 'catalog'],
            
            // Валюты
            ['key' => 'currency', 'value' => 'RUB', 'type' => 'text', 'group' => 'currency'],
            ['key' => 'currency_symbol', 'value' => '₽', 'type' => 'text', 'group' => 'currency'],
            ['key' => 'currency_position', 'value' => 'after', 'type' => 'text', 'group' => 'currency'],
            
            // Политики и документы
            ['key' => 'privacy_policy_url', 'value' => '', 'type' => 'url', 'group' => 'policies'],
            ['key' => 'terms_of_service_url', 'value' => '', 'type' => 'url', 'group' => 'policies'],
            ['key' => 'return_policy_url', 'value' => '', 'type' => 'url', 'group' => 'policies'],
            
            // Уведомления на сайте
            ['key' => 'show_banner', 'value' => '0', 'type' => 'checkbox', 'group' => 'notifications'],
            ['key' => 'banner_text', 'value' => '🎉 Специальное предложение! Скидка 15% на все саженцы туи!', 'type' => 'textarea', 'group' => 'notifications'],
            ['key' => 'footer_text', 'value' => '© ' . date('Y') . ' GreenPlant. Все права защищены.', 'type' => 'textarea', 'group' => 'notifications'],
            
            // Email уведомления
            ['key' => 'order_notification_email', 'value' => 'orders@greenplant.ru', 'type' => 'email', 'group' => 'email'],
            ['key' => 'order_email_subject', 'value' => 'Ваш заказ на GreenPlant', 'type' => 'text', 'group' => 'email'],
            ['key' => 'admin_order_notification', 'value' => '1', 'type' => 'checkbox', 'group' => 'email'],
        ];

        foreach ($settings as $setting) {
            Setting::updateOrCreate(
                ['key' => $setting['key']],
                $setting
            );
        }
    }
}

