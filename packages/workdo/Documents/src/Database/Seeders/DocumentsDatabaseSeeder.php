<?php

namespace Workdo\Documents\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DocumentsDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->call(PermissionTableSeeder::class);
        $this->call(EmailTemplateTableSeeder::class);
        if (module_is_active('LandingPage')) {
            $this->call(MarketPlaceSeederTableSeeder::class);
        };
    }
}
