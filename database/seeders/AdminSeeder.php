<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminRole = Role::firstOrCreate(['name' => 'Admin']);

        User::firstOrCreate(
            ['email' => 'admin@cuponera.com'],
            [
                'password' => Hash::make('Admin123.'),
                'username' => 'admin',
                'names' => 'Admin',
                'surnames' => 'Principal',
                'dui' => '05553456-9',
                'birthdate' => '1990-01-01',
                'role_uuid' => $adminRole->role_uuid,
            ]
        );
    }
}