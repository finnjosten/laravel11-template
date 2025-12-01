<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Ramsey\Uuid\Uuid as UUID;
use Illuminate\Validation\Rules\Password as PasswordRule;

class ProfileController extends Controller {

    /** Data functions **/

    public function show() {

        // Check if the user has permission to view their profile
        $this->checkSinglePermission('profile.view');

        if (API_RESPONSE) {
            return response()->json([
                'status' => 'success',
                'data' => Auth::user()
            ]);
        }
        return view('pages.account.profile.index');
    }



    public function edit() {
        // Check if the user has permission to view the profile edit page
        $this->checkSinglePermission('profile.update.get');

        return view('pages.account.profile.manage', ['mode' => 'edit']);
    }

    public function update(Request $request) {
        // Check if the user has permission to update their profile
        $this->checkSinglePermission('profile.update.post');

        $user = Auth::user();
        $data = $request->only('name', 'email', 'cur_password', 'password', 'password_confirmation');

        $validation = $this->validate($data, [
            'email' => 'required|email',
            'name' => ['required', 'unique:users,name,' . $user->id, 'regex:/^[a-zA-Z0-9_-]{3,}$/'],
            'email' => ['required', 'email', 'unique:users,email,' . $user->id],
        ]);

        if ($validation['success'] == false) return $validation['redirect'];

        // Check the username for 3 letters or more, A to Z and - or _
        if (!preg_match('/^[a-zA-Z0-9_-]{3,}$/', $data['name'])) {
            if (API_RESPONSE) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Username must be at least 3 characters long and can only contain letters, numbers, underscores, or hyphens'
                ], 422);
            }
            return redirect()->back()->with('error', 'Username must be at least 3 characters long and can only contain letters, numbers, underscores, or hyphens')->withInput();
        }

        $update = $this->updatePassword($data, $user);

        if ($update['success'] == false && !empty($update['redirect'] ?? "")) return $update['redirect'];


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
        // Check if the user has permission to view the profile delete page
        $this->checkSinglePermission('profile.destroy.get');

        return view('pages.account.profile.manage', ['mode' => 'delete']);
    }

    public function destroy() {
        // Check if the user has permission to delete their profile
        $this->checkSinglePermission('profile.destroy.post');

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






    private function updatePassword($data, $user) {
        $passwordFields = [
            !empty($data['password']),
            !empty($data['cur_password']),
            !empty($data['password_confirmation'] ?? ''),
        ];


        if (array_sum($passwordFields) == 3) {

            // Check if the current password is correct
            if (!password_verify($data['cur_password'], $user->password)) {
                return [
                    'success' => false,
                    'redirect' => redirect()->back()->with('error', 'Current password is correct'),
                ];
            }

            $validation = $this->validate($data, [
                'password' => ['required', 'confirmed', PasswordRule::min(8)->letters()->numbers()->symbols()->uncompromised()],
            ], [
                'name.regex' => __('Username does not meet the requirements.'),
                'password.uncompromised' => __('The password is in a data breach. Use a different one.'),
            ]);

            if ($validation['success'] == false) return [
                'success' => false,
                'redirect' => $validation['redirect'],
            ];

            // Update the password
            $user->password = bcrypt($data['password']);
            session()->flash('success1', 'Password has been updated successfully');

            return [
                'success' => true,
            ];

        } else if (array_sum($passwordFields) > 0 && array_sum($passwordFields) < 3) {
            session()->flash('warning', 'You must fill all password fields to change your password');

            return [
                'success' => false,
            ];
        }

        return [
            'success' => true,
        ];
    }
}
