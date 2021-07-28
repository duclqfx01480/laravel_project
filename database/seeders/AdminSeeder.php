<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

// 1. Import UserModel
use App\Models\User;
// 2. Hash Facade
use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Str;


class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = new User([
            'name' => 'Admin',
            'email' => 'admin@system.com',

            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'remember_token' => Str::random(10), // random string with 10 characters
            'role'=> 'admin'
        ]);

        $admin->save();
    }
}
