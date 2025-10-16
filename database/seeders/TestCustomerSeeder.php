<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class TestCustomerSeeder extends Seeder
{
    public function run(): void
    {
        // Создаем тестового покупателя
        $customer = User::firstOrCreate(
            ['email' => 'customer@test.ru'],
            [
                'name' => 'Тестовый Покупатель',
                'password' => Hash::make('customer123'),
            ]
        );

        // Назначаем роль
        if (!$customer->hasRole('customer')) {
            $customer->assignRole('customer');
        }

        $this->command->info('Тестовый покупатель создан!');
        $this->command->info('Email: customer@test.ru');
        $this->command->info('Пароль: customer123');
    }
}

