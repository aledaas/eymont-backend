<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]
            ->forgetCachedPermissions();

        $permissions = [
            'manage content',
            'publish content',
            'answer exercises',
            'view own progress',
            'view students progress',
            'manage users',
            'access teacher panel',
            'access student panel',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate([
                'name' => $permission,
                'guard_name' => 'web',
            ]);
        }

        $superAdmin = Role::firstOrCreate([
            'name' => 'super-admin',
            'guard_name' => 'web',
        ]);

        $teacher = Role::firstOrCreate([
            'name' => 'teacher',
            'guard_name' => 'web',
        ]);

        $student = Role::firstOrCreate([
            'name' => 'student',
            'guard_name' => 'web',
        ]);

        $superAdmin->syncPermissions($permissions);

        $teacher->syncPermissions([
            'manage content',
            'publish content',
            'view students progress',
            'access teacher panel',
        ]);

        $student->syncPermissions([
            'answer exercises',
            'view own progress',
            'access student panel',
        ]);
    }
}
