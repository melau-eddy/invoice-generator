<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(RolesPermissionsSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(GenderSeeder::class);
        $this->call(StatusSeeder::class);
        $this->call(CompanySeeder::class);
        $this->call(ItemSeeder::class);
    }
}

