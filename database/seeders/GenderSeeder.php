<?php

namespace Database\Seeders;

use App\Models\Gender;
use Illuminate\Database\Seeder;

class GenderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Gender::create([
            "name"=>"male"
        ]);
        Gender::create([
            "name"=>"female"
        ]);
        Gender::create([
            "name"=>"other"
        ]);
    }
}
