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
        // \App\Models\User::factory(10)->create();
        //each time when a user created, we create some questions for the user
        \App\Models\User::factory(3)->create()->each(function($user) { 
            $user->questions()->saveMany( 
               \App\Models\Question::factory()->count(rand(1,5))->make()
            ); 
         });
    }
}
