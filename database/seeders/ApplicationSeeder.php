<?php

namespace Database\Seeders;

use App\Models\Application;
use App\Models\Organisation;
use App\Models\Plugin;
use App\Models\User;
use App\Plugins\PluginMapping;
use Illuminate\Database\Seeder;

class ApplicationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $organisation = Organisation::first();
        /**
         * @var Organisation $user
         */

        $codeigniter = new Application();
        $codeigniter->name = 'Sample Application';

        $organisation->applications()->save($codeigniter);
    }
}
