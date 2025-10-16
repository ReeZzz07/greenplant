<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class CustomerRoleSeeder extends Seeder
{
    public function run(): void
    {
        // Создаем роль "Покупатель" если её ещё нет
        $customerRole = Role::firstOrCreate(['name' => 'customer']);

        // Создаем разрешения для покупателей
        $permissions = [
            'view own orders',
            'create orders',
            'manage own profile',
            'manage own addresses',
        ];

        foreach ($permissions as $permissionName) {
            Permission::firstOrCreate(['name' => $permissionName]);
        }

        // Назначаем разрешения роли
        $customerRole->syncPermissions($permissions);

        $this->command->info('Роль "Покупатель" создана с разрешениями!');
    }
}
