<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class RecreateAdminSeeder extends Seeder
{
    public function run(): void
    {
        // Создаем/обновляем админа
        $admin = User::updateOrCreate(
            ['email' => 'admin@greenplant.ru'],
            [
                'name' => 'Администратор',
                'password' => Hash::make('admin123'),
            ]
        );

        // Назначаем роль
        if (!$admin->hasRole('admin')) {
            $admin->assignRole('admin');
        }

        $this->command->info('Администратор создан/обновлен!');
        $this->command->info('Email: admin@greenplant.ru');
        $this->command->info('Пароль: admin123');
    }
}

