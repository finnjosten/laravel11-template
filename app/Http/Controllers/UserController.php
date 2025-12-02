<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

use App\Models\User;
use Ramsey\Uuid\Uuid as UUID;

use App\Events\UserStored;
use App\Events\UserVerified;

class UserController extends Controller {

    /** Data functions **/

    public function index() {

        // Check if the user has permission to view all users
        $this->checkSinglePermission('users.index');

        // Check if the user is an admin
        $users = User::all();

        if (API_RESPONSE) {
            return response()->json([
                'status' => 'success',
                'data' => $users
            ]);
        }
        return view('pages.account.users.index', compact('users'));
    }

    public function show($id) {

        // Check if the user has permission to view a specific user
        $this->checkSinglePermission('users.show');

        // Check if the user is an admin
        $user = User::find($id);

        if (!$user) {
            if (API_RESPONSE) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'User not found'
                ], 404);
            }
            return redirect()->route('dashboard.user')->with('error', 'User not found');
        }

        if ($user->id == Auth::user()->id) {
            if (API_RESPONSE) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'To view your own account use the profile endpoints'
                ], 403);
            }
            return redirect()->route('dashboard.user')->with('error', 'To view your own account visit your profile');
        }

        if (API_RESPONSE) {
            return response()->json([
                'status' => 'success',
                'data' => $user
            ]);
        }
        return view('pages.account.users.manage', ['mode' => 'view', 'user' => $user]);
    }






    public function create() {

        // Check if the user has permission to get the page to create users
        $this->checkSinglePermission('users.create.get');

        return view('pages.account.users.manage', ['mode' => 'add']);
    }

    public function store(Request $request) {

        // Check if the user has permission to create users
        $this->checkSinglePermission('users.create.post');

        $data = $request->only('name', 'email', 'uuid', 'password', 'password_confirmation', 'admin', 'blocked', 'verified');

        $validation = $this->validate($data, [
            'name' => ['required'],
            'email' => ['required', 'email', 'unique:users'],
            'uuid' => ['nullable', 'unique:users'],
            'password' => ['required', 'confirmed', 'min:8'],
        ]);

        if ($validation['success'] == false) return $validation['redirect'];

        // Directly use request data for checkboxes instead of validation
        // This handles the case when checkboxes are unchecked
        $admin = $request->has('admin') ? true : false;
        $blocked = $request->has('blocked') ? true : false;
        $verified = $request->has('verified') ? true : false;

        foreach (['admin', 'blocked', 'verified'] as $field) {
            $$field = false; // Default to current value
            if ($request->has($field)) {
                $$field = ($request->input($field) == 'on' || $request->input($field) == '1') ? true : false;
            }
        }

        if (!isset($data['uuid']) || empty($data['uuid'])) $data['uuid'] = UUID::uuid4()->toString();

        // Create the user
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'uuid' => $data['uuid'] ?? UUID::uuid4()->toString(),
            'password' => bcrypt($data['password']),
            'admin' => $admin,
            'blocked' => $blocked,
            'verified' => $verified,
        ]);

        // Send the user an email about their account creation
        event(new UserStored($user));

        if (API_RESPONSE) {
            return response()->json([
                'status' => 'success',
                'message' => 'User has been created',
                'data' => $user
            ]);
        }
        return redirect()->route('dashboard.user')->with('success', 'User has been created');

    }






    public function edit($id) {

        // Check if the user has permission to get the page to update the users
        $this->checkSinglePermission('users.update.get');

        $user = User::find($id);

        if (!$user) {
            if (API_RESPONSE) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'User not found'
                ], 404);
            }
            return redirect()->route('dashboard.user')->with('error', 'User not found');
        }

        if ($user->id == Auth::user()->id) {
            if (API_RESPONSE) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'To view your own account use the profile endpoints'
                ], 403);
            }
            return redirect()->route('dashboard.user')->with('error', 'To edit your own account visit your profile');
        }

        return view('pages.account.users.manage', ['mode' => 'edit', 'user' => $user]);
    }

    public function update(Request $request, $id) {

        // Check if the user has permission to update the users
        $this->checkSinglePermission('users.update.post');

        $user = User::find($id);

        if (!$user) {
            if (API_RESPONSE) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'User not found'
                ], 404);
            }
            return redirect()->route('dashboard.user')->with('error', 'User not found');
        }

        $data = $request->only('name', 'email', 'admin', 'blocked', 'verified');

        $validation = $this->validate($data, [
            'name' => 'required',
            'email' => 'required|email',
        ]);

        if ($validation['success'] == false) return $validation['redirect'];

        // Directly use request data for checkboxes instead of validation
        // This handles the case when checkboxes are unchecked
        $admin = $request->has('admin') ? true : false;
        $blocked = $request->has('blocked') ? true : false;
        $verified = $request->has('verified') ? true : false;

        foreach (['admin', 'blocked', 'verified'] as $field) {
            $$field = $user->$field; // Default to current value
            if ($request->has($field)) {
                $$field = ($request->input($field) == 'on' || $request->input($field) == '1') ? true : false;
            }
        }

        $send_verified_event = false;
        if ($verified && !$user->hasVerifiedEmail()) {
            // If marking as verified and not already verified, set the timestamp
            $data['email_verified_at'] = Carbon::now()->toDateTimeString();
            $send_verified_event = true;
        } elseif (!$verified) {
            // If unmarking as verified, set to null
            $data['email_verified_at'] = null;
        } else {
            // Keep the existing value
            $data['email_verified_at'] = $user->email_verified_at;
        }

        $user->update([
            'name' => $data['name'],
            'email' => $data['email'],
            'admin' => $admin,
            'blocked' => $blocked,
            'verified' => $verified,
        ]);

        if ($send_verified_event) {
            // Notify that the user has been verified
            event(new UserVerified($user, true));
        }

        if (API_RESPONSE) {
            return response()->json([
                'status' => 'success',
                'message' => 'User has been updated',
                'data' => $user
            ]);
        }
        return redirect()->route('dashboard.user')->with('success', 'User has been updated');

    }



    public function trash($id) {

        // Check if the user has permission to get the page to delete users
        $this->checkSinglePermission('users.destroy.get');

        $user = User::find($id);

        if (!$user) {
            if (API_RESPONSE) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'User not found'
                ], 404);
            }
            return redirect()->route('dashboard.user')->with('error', 'User not found');
        }

        if ($user->id == Auth::user()->id) {
            if (API_RESPONSE) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'You can\'t delete yourself'
                ], 403);
            }
            return redirect()->route('dashboard.user')->with('error', 'You can\'t delete yourself');
        }

        return view('pages.account.users.manage', ['mode' => 'delete', 'user' => $user]);
    }

    public function destroy($id) {

        // Check if the user has permission to delete users
        $this->checkSinglePermission('users.destroy.post');

        $user = User::find($id);

        if (!$user) {
            if (API_RESPONSE) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'User not found'
                ], 404);
            }
            return redirect()->route('dashboard.user')->with('error', 'User not found');
        }

        if ($user->id == Auth::user()->id) {
            if (API_RESPONSE) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'You can\'t delete yourself'
                ], 403);
            }
            return redirect()->route('dashboard.user')->with('error', 'You can\'t delete yourself');
        }

        $user->tokens()->delete(); // Revoke all access tokens
        $user->delete();

        if (API_RESPONSE) {
            return response()->json([
                'status' => 'success',
                'message' => 'User has been deleted'
            ]);
        }
        return redirect()->route('dashboard.user')->with('success', 'User has been deleted');
    }

}
