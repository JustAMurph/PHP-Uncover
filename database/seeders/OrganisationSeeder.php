<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class OrganisationSeeder extends Seeder
{
    public function run()
    {
        DB::table('organisations')->insert([
            'name' => 'My Organisation',
        ]);
    }
}
