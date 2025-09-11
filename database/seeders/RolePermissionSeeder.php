<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // buat role superadmin
        $superAdmin = Role::firstOrCreate(['name' => 'superadmin']);

        // buat beberapa permission dasar (untuk kelola role/permission)
        $permissions = ['manage roles', 'manage permissions', 'view dashboard'];

        foreach ($permissions as $perm) {
            Permission::firstOrCreate(['name' => $perm]);
        }

        // superadmin dapat semua permission
        $superAdmin->syncPermissions(Permission::all());
    }
}
