<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Ramsey\Uuid\Uuid as UUID;

class ProfileController extends Controller {

    /** Data functions **/

    public function show() {
        if (API_RESPONSE) {
            return response()->json([
                'status' => 'success',
                'data' => Auth::user()
            ]);
        }
        return view('pages.account.profile.index');
    }



    public function edit() {
        return view('pages.account.profile.manage', ['mode' => 'edit']);
    }

    public function update(Request $request) {
        $user = Auth::user();
        $data = $request->only('name', 'email', 'cur_password', 'new_password');

        $this->validate($data, [
            'name' => 'required|unique:users,name,' . $user->id,
            'email' => 'required|email',
        ]);

        if (!empty($data['new_password']) && !empty($data['cur_password'])) {
            // Check if the current password is correct
            if (!password_verify($data['cur_password'], $user->password)) {
                return redirect()->back()->with('error', 'Current password is correct');
            }

            // Validate the new password
            if (strlen($data['new_password']) < 8) {
                return redirect()->back()->with('error', 'New password must be at least 8 characters long');
            }

            // Update the password
            $user->password = bcrypt($data['new_password']);
            session()->flash('success1', 'Password has been updated successfully');
        } else {
            if (!empty($data['new_password']) || !empty($data['cur_password'])) {
                session()->flash('warning', 'You must fill both password fields to change your password');
            }
        }

        $user->update([
            'name' => $data['name'],
            'email' => $data['email'],
        ]);

        if (API_RESPONSE) {
            return response()->json([
                'status' => 'success',
                'message' => 'User has been updated',
                'data' => $user
            ]);
        }

        return redirect()->route('profile')->with('success', 'Profile has been updated');
    }



    public function trash() {
        return view('pages.account.profile.manage', ['mode' => 'delete']);
    }

    public function destroy() {

        if (!Auth::user()) {
            if (API_RESPONSE) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'You must be logged in to delete your account'
                ], 401);
            }
            return redirect()->route('login')->with('error', 'You must be logged in to delete your account');
        }

        // Revoke all the access tokens
        Auth::user()->tokens()->delete();

        // Logout the user
        if (request()->hasSession()) {
            request()->session()->invalidate();
            request()->session()->regenerateToken();
        }

        Auth::user()->delete();

        if (API_RESPONSE) {
            return response()->json([
                'status' => 'success',
                'message' => 'Your account has been deleted'
            ]);
        }
        return redirect()->route('login')->with('success', 'Your account has been deleted');
    }

}
