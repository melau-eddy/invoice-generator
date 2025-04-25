<?php

namespace Database\Seeders;

use App\Models\Profile;
use App\Models\User;
use Faker\Factory;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::factory()->count(200)->create();
        User::create(['name' => 'admin', 'email' => 'admin@gmail.com', 'password' => bcrypt('password')])->assignRole('admin');
        User::create(['name' => 'user1', 'email' => 'user1@gmail.com', 'password' => bcrypt('password')])->assignRole('user');
        $users=User::all();
//        foreach ($users as $user) {
//            Profile::create([
//                "user_id"=>$user->id
//            ]);
//        }
    }
}
