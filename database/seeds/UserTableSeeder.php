<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){
        factory(\CodeProject\Entities\User::class, 5)->create();
    }
}
