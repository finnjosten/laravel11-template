<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Ramsey\Uuid\Uuid as UUID;

class UserController extends Controller {

    /** Data functions **/

    public function index() {
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

        if ($user->id == auth()->user()->id) {
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
        return view('pages.account.users.manage', ['mode' => 'add']);
    }

    public function store(Request $request) {
        $data = $request->only('name', 'email', 'uuid', 'password', 'admin', 'blocked', 'verified');

        $this->validate($data, [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'uuid' => 'nullable|unique:users',
            'password' => 'required|min:8',
        ]);

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
        if(!auth()->user()->isAdmin()) {
            return redirect()->route('dashboard.user')->with('error', 'You do not have permission to access this page');
        }

        $user = User::findOrFail($id);

        if ($user->id == auth()->user()->id) {
            return redirect()->route('dashboard.user')->with('error', 'To edit your own account visit your profile');
        }

        return view('pages.account.users.manage', ['mode' => 'edit', 'user' => $user]);
    }

    public function update(Request $request, $id) {
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

        $data = $request->only('name', 'email');

        $this->validate($data, [
            'name' => 'required',
            'email' => 'required|email',
        ]);

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

        $user->update([
            'name' => $data['name'],
            'email' => $data['email'],
            'admin' => $admin,
            'blocked' => $blocked,
            'verified' => $verified,
        ]);

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
        $user = User::findOrFail($id);
        return view('pages.account.users.manage', ['mode' => 'delete', 'user' => $user]);
    }

    public function destroy($id) {
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

        // Check if the user is an admin
        if ($user->id == auth()->user()->id) {
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
