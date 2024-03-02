<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MainCompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('main_company')->insert([
            'name' => 'Main Company',
            'contact' => '08123456789',
            'address' => 'Jln.Kebenaran',
        ]);
    }
}
