<?php

namespace Database\Seeders;

use App\Models\Items;
use Illuminate\Database\Seeder;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Items::factory()->count(10)->create();
    }
}
