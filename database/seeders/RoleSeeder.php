<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Вызываем RoleAndPermissionSeeder для совместимости с тестами
        $this->call(RoleAndPermissionSeeder::class);
    }
}

