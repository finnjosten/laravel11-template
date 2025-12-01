<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use \App\Models\Role;
use \App\Models\User;

class SetUserRole extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:role';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Set a users role';

    /**
     * Execute the console command.
     */
    public function handle() {
        $users = User::all();
        $users = $users->mapWithKeys(function ($user) {
            return [$user->id => $user->email];
        })->toArray();

        $roles = Role::all();
        $roles = $roles->mapWithKeys(function ($role) {
            return [$role->id => $role->slug];
        })->toArray();

        $user = $this->choice('Select a user', $users, 0);
        $role = $this->choice('Select a role', $roles, 0);

        $user = User::whereEmail($user)->first();
        if (!$user) {
            $this->error('User not found.');
            return;
        }

        $role = Role::whereSlug($role)->first();
        if (!$role) {
            $this->error('Role not found.');
            return;
        }

        $user->role_slug = $role->slug;
        $user->save();

        $this->info("User '{$user->email}' has been assigned the role '{$role->name}' successfully.");
    }
}
