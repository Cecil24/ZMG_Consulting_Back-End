<?php

namespace Database\Seeders;

use App\Common\Roles;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::create([
            'name' => strtoupper(Roles::CEO),
            'guard_name' => 'web',
        ]);

        Role::create([
            'name' => strtoupper(Roles::HR_MANAGER),
            'guard_name' => 'web',
        ]);

        Role::create([
            'name' => strtoupper(Roles::ADMINISTRATOR),
            'guard_name' => 'web',
        ]);

        Role::create([
            'name' => strtoupper(Roles::OPS_MANAGER),
            'guard_name' => 'web',
        ]);

        Role::create([
            'name' => strtoupper(Roles::TAX_CONSULTANTS),
            'guard_name' => 'web',
        ]);

        Role::create([
            'name' => strtoupper(Roles::BUSINESS_DEVELOPER),
            'guard_name' => 'web',
        ]);
    }
}
