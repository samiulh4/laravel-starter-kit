<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersGenderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users_gender')->truncate();
        DB::table('users_gender')->insert([
            ['name' => 'Male', 'gender_code' => 'M', 'is_active' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Female', 'gender_code' => 'F', 'is_active' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Not Applicable', 'gender_code' => 'N', 'is_active' => 1, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
