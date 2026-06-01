<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        foreach (UserRole::cases() as $role) {
            Role::firstOrCreate(['name' => $role->value, 'guard_name' => 'web']);
        }

        if (User::count() === 0) {
            $admin = User::create([
                'name'     => 'Administrator',
                'email'    => 'admin@mail.in',
                'password' => bcrypt('password'),
                'is_active' => true,
            ]);
            $admin->assignRole(UserRole::Admin->value);
        }
    }
}
