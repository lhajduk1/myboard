<?php

namespace Database\Seeders;

use App\Support\Auth\Access;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        foreach (Access::permissions() as $permission) {
            Permission::query()->updateOrCreate([
                'name' => $permission,
                'guard_name' => 'web',
            ]);
        }

        foreach (Access::ROLES as $roleName => $permissions) {
            $role = Role::query()->updateOrCreate([
                'name' => $roleName,
                'guard_name' => 'web',
            ]);

            $role->syncPermissions($permissions);
        }

        app(PermissionRegistrar::class)->forgetCachedPermissions();
    }
}
