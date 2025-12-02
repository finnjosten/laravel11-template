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
            'permissions' => ['*'],
        ]);

        Role::factory()->create([
            'name' => 'Admin',
            'slug' => 'admin',
            'permissions' => [
                'password.*',
                'profile.*',
                'user.*',
                'role.*',
                'verify.*',
                'auth.*',
                'menu.*',
            ],
        ]);

        Role::factory()->create([
            'name' => 'User',
            'slug' => 'user',
            'permissions' => [
                'password.*',
                'profile.*',
                'verify.*',
                'auth.*',
                'menu.user',
            ],
        ]);



        $users = unserialize(env('USER_DATA', 'a:0:{}'));

        foreach ($users as $user) {
            User::factory()->create($user);
        }

    }
}
