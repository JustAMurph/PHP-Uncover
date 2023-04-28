<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Eoin Murphy',
            'email' => 'eoin.m.murphy@gmail.com',
            'password' => Hash::make('archer0334'),
            'organisation_id' => 1
        ]);
    }
}
