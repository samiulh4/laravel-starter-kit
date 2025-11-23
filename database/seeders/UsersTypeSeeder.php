<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users_type')->truncate();
        DB::table('users_type')->insert([
            ['name' => 'Super Admin', 'user_type_code' => 'super-admin', 'is_active' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Admin', 'user_type_code' => 'admin', 'is_active' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'User', 'user_type_code' => 'user', 'is_active' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Guest', 'user_type_code' => 'guest', 'is_active' => 1, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
