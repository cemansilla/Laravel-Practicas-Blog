<?php

use Illuminate\Database\Seeder;
use \App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        #User::create(["name" => "Sofia", "email" => "sofylatable@gmail.com", "password" => "otro"]);

        factory(App\User::class)->times(40)->create();
    }
}
