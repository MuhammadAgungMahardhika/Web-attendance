<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        DB::table('users')->insert([
            'role_id' => 1,
            'main_company_id' => 1,
            'name' => 'Super Admin',
            'email' => 'superadmin@gmail.com',
            'status' => 'active',
            'password' => Hash::make('password')
        ]);

        DB::table('users')->insert([
            'role_id' => 3,
            'main_company_id' => 1,
            'name' => 'karyawan1',
            'email' => 'karyawan1@gmail.com',
            'status' => 'active',
            'password' => Hash::make('password')
        ]);
    }
}
