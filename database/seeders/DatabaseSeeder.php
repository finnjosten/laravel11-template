<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        Role::factory()->create([
            'name' => 'Super Admin',
            'slug' => 'super-admin',
            'permissions' => serialize(['*']),
        ]);

        Role::factory()->create([
            'name' => 'Admin',
            'slug' => 'admin',
            'permissions' => serialize(['*']),
        ]);

        Role::factory()->create([
            'name' => 'User',
            'slug' => 'user',
            'permissions' => serialize([
                'password.*',
                'profile.*',
                'verify.*',
                'auth.*',
            ]),
        ]);



        $users = unserialize(env('USER_DATA', 'a:0:{}'));

        foreach ($users as $user) {
            User::factory()->create($user);
        }

    }
}
