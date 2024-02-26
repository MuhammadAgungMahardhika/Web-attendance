<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            'Super Admin',
            'Admin',
            'User'
        ];

        for ($i = 0; $i < count($data); $i++) {
            $roleName = $data[$i];

            DB::table('roles')->insert([
                'role' => $roleName
            ]);
        }
    }
}
