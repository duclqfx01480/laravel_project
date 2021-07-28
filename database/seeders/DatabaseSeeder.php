<?php

namespace Database\Seeders;

use App\Models\Tag;
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
        // \App\Models\Tag::factory(10)->create();

        $this->call(TagSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(AdminSeeder::class);
        //$this->call(HobbySeeder::class);
    }
}
