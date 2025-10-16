<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Создание администратора
        $admin = User::create([
            'name' => 'Администратор',
            'email' => 'admin@greenplant.ru',
            'password' => Hash::make('admin123'),
            'email_verified_at' => now(),
        ]);
        $admin->assignRole('admin');

        // Создание контент-менеджера
        $manager = User::create([
            'name' => 'Контент-менеджер',
            'email' => 'manager@greenplant.ru',
            'password' => Hash::make('manager123'),
            'email_verified_at' => now(),
        ]);
        $manager->assignRole('content-manager');
    }
}

