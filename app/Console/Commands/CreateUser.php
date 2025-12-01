<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use \App\Models\Role;
use \App\Models\User;

class CreateUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new user';

    /**
     * Execute the console command.
     */
    public function handle() {
        $roles = Role::all();
        $roles = $roles->mapWithKeys(function ($role) {
            return [$role->id => $role->slug];
        })->toArray();

        $email = $this->ask('Enter the email address for the new user');
        $password = $this->secret('Enter the password for the new user');
        $role_slug = $this->choice('Select a role for the new user', $roles, 0);
        $first_name = $this->ask('Enter the first name of the new user');
        $sure_name = $this->ask('Enter the sure name of the new user');

        $role = Role::whereSlug($role_slug)->first();
        if (!$role) {
            $this->error("Role '{$role_slug}' does not exist.");
            return;
        }

        // Create the user
        User::create([
            'email' => $email,
            'password' => bcrypt($password),
            'role_slug' => $role->slug,
            'first_name' => $first_name,
            'sure_name' => $sure_name,
        ]);

        $this->info("User '{$email}' has been created successfully.");
    }
}
