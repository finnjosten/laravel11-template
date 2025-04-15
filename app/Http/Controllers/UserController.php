<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use COM;

class UserController extends Controller
{

    public function profile() {
        return view('pages.account.profile.index');
    }

    public function create() {
        return view('pages.account.users.manage', ['mode' => 'add']);
    }

    public function edit(User $user) {
        if(!auth()->user()->isAdmin()) {
            return redirect()->route('dashboard.user')->with('error', 'You do not have permission to access this page');
        }
        if ($user->id == auth()->user()->id) {
            return redirect()->route('dashboard.user')->with('error', 'To edit your own account visit your profile');
        }
        return view('pages.account.users.manage', ['mode' => 'edit', 'user' => $user]);
    }

    public function editProfile() {
        return view('pages.account.profile.manage', ['mode' => 'edit']);
    }

    public function trash(User $user) {
        if(!auth()->user()->isAdmin()) {
            return redirect()->route('dashboard.user')->with('error', 'You do not have permission to access this page');
        }
        return view('pages.account.users.manage', ['mode' => 'delete', 'user' => $user]);
    }

    public function trashProfile() {
        return view('pages.account.profile.manage', ['mode' => 'delete']);
    }


    public function update(Request $request, User $user) {

        // Check if the user is an admin
        if(!auth()->user()->isAdmin()) {
            return redirect()->route('dashboard.user')->with('error', 'You do not have permission to access this page');
        }
        // Check if the user is trying to edit their own account
        if ($user->id == auth()->user()->id) {
            return redirect()->route('dashboard.user')->with('error', 'To edit your own account visit your profile');
        }

        // Validate the request
        try {
            $validated = $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }

        // Clear any previous errors
        $request->session()->forget(['errors', 'success', 'info', 'warning']);

        // Directly use request data for checkboxes instead of validation
        // This handles the case when checkboxes are unchecked
        $admin = $request->has('admin') ? true : false;
        $blocked = $request->has('blocked') ? true : false;
        $verified = $request->has('verified') ? true : false;

        $user->name = $validated['name'] ?? $user->name;
        $user->email = $validated['email'] ?? $user->email;
        $user->admin = $admin;
        $user->blocked = $blocked;
        $user->verified = $verified;
        $user->save();

        return redirect()->route('dashboard.user')->with('success', 'User has been updated');

    }

    public function destroy(User $user) {

        // Check if the user is an admin
        if (!auth()->user()->isAdmin()) {
            return redirect()->route('dashboard.user')->with('error', 'You do not have permission to access this page');
        }
        // Check if the user is trying to delete their own account
        if ($user->id == auth()->user()->id) {
            return redirect()->route('dashboard.user')->with('error', 'You can\'t delete yourself');
        }

        $user->delete();
        return redirect()->route('dashboard.user')->with('success', 'User has been deleted');

    }

    public function destroyProfile() {
        $user = auth()->user();

        $user->delete();
        return redirect()->route('login')->with('success', 'Your account has been deleted');

    }

}
