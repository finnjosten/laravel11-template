<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use COM;

class UserController extends Controller
{

    public function create() {
        return view('pages.account.user-edit', ['mode' => 'add']);
    }

    public function edit(User $user) {
        if($user->id == auth()->user()->id) {
            return redirect()->route('dashboard.user');
        }
        return view('pages.account.user-edit', ['mode' => 'edit', 'user' => $user]);
    }

    public function trash(User $user) {
        if($user->id == auth()->user()->id) {
            return redirect()->route('dashboard.user');
        }
        return view('pages.account.user-edit', ['mode' => 'delete', 'user' => $user]);
    }


    public function update(Request $request, User $user) {

        // Validate the request
        try {
            $validated = $request->validate([
                'name' => 'required',
                'email' => 'required',
                'admin' => 'nullable',
                'blocked' => 'nullable',
                'verified' => 'nullable',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->with('error', 'A field did not meet the requirements')->withInput();
        }

        // Clear any previous errors
        $request->session()->forget(['errors', 'success', 'info', 'warning']);

        $admin = isset($validated['admin']) ? true : false;
        $blocked = isset($validated['blocked']) ? true : false;
        $verified = isset($validated['verified']) ? true : false;

        //dd($admin,$blocked,$verified);

        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'admin' => $admin,
            'blocked' => $blocked,
            'verified' => $verified,
        ]);

        //dd($user);

        return redirect()->route('dashboard.user')->with('success', 'User has been updated');

    }

    public function delete(User $user) {

        $user->delete();

        return redirect()->route('dashboard.user')->with('success', 'User has been deleted');

    }

}
