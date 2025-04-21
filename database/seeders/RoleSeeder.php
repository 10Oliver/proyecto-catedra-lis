<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    public function run()
    {
        DB::table('role')->insert([
            [
                'role_uuid' => (string) Str::uuid(),
                'name' => 'Admin',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'role_uuid' => (string) Str::uuid(),
                'name' => 'Empresa',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'role_uuid' => (string) Str::uuid(),
                'name' => 'Cliente',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
