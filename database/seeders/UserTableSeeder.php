<?php

namespace Database\Seeders;

use App\Common\Roles;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'John',
            'surname' => 'Doe',
            'id_number' => '4567890765234568',
            'email' => 'johnD@gmail.com',
            'password' => bcrypt('Zmg@123#'),
        ])->assignRole(strtoupper(Roles::CEO));
    }
}
