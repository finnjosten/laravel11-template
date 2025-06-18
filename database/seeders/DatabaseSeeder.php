<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Ramsey\Uuid\Uuid as UUID;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void {

        if(env('SETTING_DEFAULT_ACCOUNTS')) {
            \App\Models\User::factory()->create(array(
                'uuid' => UUID::uuid4()->toString(),
                'name' =>'admin',
                'email' => 'admin@app.com',
                'password' => Hash::make('password'),
                'blocked' => false,
                'verified' => true,
                'admin' => true,
            ));

            \App\Models\User::factory()->create(array(
                'uuid' => UUID::uuid4()->toString(),
                'name' =>'user',
                'email' => 'user@app.com',
                'password' => Hash::make('password'),
                'blocked' => false,
                'verified' => true,
                'admin' => false,
            ));
        }


        // Seed default users
        $users = unserialize(env('USER_DATA', 'a:0:{}'));

        foreach ($users as $user) {
            User::factory()->create($user);
        }

    }
}
