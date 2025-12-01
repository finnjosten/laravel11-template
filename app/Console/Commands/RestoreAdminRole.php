<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use \App\Models\Role;
use \App\Models\User;

class RestoreAdminRole extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'role:restore';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Restore the default "admin" and "super-admin" role if it has been deleted or modified.';

    /**
     * Execute the console command.
     */
    public function handle() {
        $roles = [
            [
                'name' => 'Admin',
                'slug' => 'admin',
                'permissions' => serialize(['*']),
            ],
            [
                'name' => 'Super Admin',
                'slug' => 'super-admin',
                'permissions' => serialize(['*']),
            ],
        ];

        foreach ($roles as $roleData) {
            $role = Role::where('slug', $roleData['slug'])->first();

            if (!$role) {
                Role::create($roleData);
                $this->info("Role '{$roleData['name']}' has been restored.");
            } else {
                Role::where('slug', $roleData['slug'])
                    ->update([
                        'name' => $roleData['name'],
                        'permissions' => $roleData['permissions'],
                    ]);
                $this->info("Role '{$roleData['name']}' already exists and has been updated.");
            }

            // Check if any users have the role
            $user_count = User::where('role_slug', $roleData['slug'])->count();

            if ($user_count === 0) {
                $this->warn("No users found with the '{$roleData['name']}' role.");
            } else {
                $this->info("Found {$user_count} users with the '{$roleData['name']}' role.");
            }

        }

        $this->info("Roles have been restored or updated successfully. You can assign these roles with `php artisan user:role` command, or create a new user with `php artisan user:create` command.");
    }
}
