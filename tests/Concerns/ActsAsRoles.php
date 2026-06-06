<?php

declare(strict_types=1);

namespace Tests\Concerns;

use App\Enums\UserRole;
use App\Models\User;
use Spatie\Permission\Models\Role;

trait ActsAsRoles
{
    protected function seedRoles(): void
    {
        foreach (UserRole::cases() as $role) {
            Role::firstOrCreate(['name' => $role->value, 'guard_name' => 'web']);
        }
    }

    protected function createUserWithRole(UserRole $role, array $attributes = []): User
    {
        $this->seedRoles();

        $user = User::factory()->create(array_merge(['is_active' => true], $attributes));
        $user->assignRole($role->value);

        return $user;
    }
}
