<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\RoleRedirect;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Buat role superadmin jika belum ada
        $superadminRole = Role::firstOrCreate([
            'name' => 'superadmin',
            'guard_name' => 'web'
        ]);

        // Buat user superadmin jika belum ada
        $superadmin = User::firstOrCreate(
            ['email' => 'superadmin@gmail.com'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('admin123'),
            ]
        );

        // Assign role ke user
        $superadmin->assignRole($superadminRole);

        // Buat RoleRedirect khusus superadmin jika belum ada
        RoleRedirect::firstOrCreate(
            ['role_name' => 'superadmin'],
            ['route_name' => 'superadmin.users.index']
        );
    }
}
