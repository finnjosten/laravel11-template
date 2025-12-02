<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

use App\Models\Role;
use Ramsey\Uuid\Uuid as UUID;

class RoleController extends Controller {

    /** Data functions **/

    public function index() {

        // Check if the user has permission to view all roles
        $this->checkSinglePermission('roles.index');

        // Check if the user is an admin
        $roles = Role::all();

        if (API_RESPONSE) {
            return response()->json([
                'status' => 'success',
                'data' => $roles
            ]);
        }
        return view('pages.account.role.index', compact('roles'));
    }

    public function show($id) {

        // Check if the user has permission to view a specific role
        $this->checkSinglePermission('roles.show');

        // Check if the user is an admin
        $role = Role::find($id);

        if (!$role) {
            if (API_RESPONSE) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Role not found'
                ], 404);
            }
            return redirect()->route('dashboard.role')->with('error', 'Role not found');
        }

        if (API_RESPONSE) {
            return response()->json([
                'status' => 'success',
                'data' => $role
            ]);
        }
        return view('pages.account.role.manage', ['mode' => 'view', 'role' => $role]);
    }






    public function create() {

        // Check if the user has permission to get the page to create roles
        $this->checkSinglePermission('roles.create.get');

        return view('pages.account.role.manage', ['mode' => 'add']);
    }

    public function store(Request $request) {

        // Check if the user has permission to create roles
        $this->checkSinglePermission('roles.create.post');

        $data = $request->only('name', 'slug', 'permissions');

        $validation = $this->validate($data, [
            "name" => ['required', 'string', 'max:64'],
            "slug" => ['required', 'string', 'max:64', 'unique:roles,slug'],
            "permissions" => ['required', 'string', 'max:64000'],
        ]);

        if ($validation['success'] == false) return $validation['redirect'];

        $perms = [];

        if (str_starts_with($data['permissions'], '{') || str_starts_with($data['permissions'], '[')) {
            $perms = json_decode($data['permissions'], true);
        } else if (str_starts_with($data['permissions'], 'a:')) {
            $perms = unserialize($data['permissions']);
        } else {
            if (API_RESPONSE) {
                return response()->json([
                    "status" => "error",
                    "code" => "invalid_permissions_format",
                ], 422);
            }
            return redirect()->route('dashboard.role')->with('error', 'Invalid permissions format')->withInput();
        }

        // Create the role
        $role = Role::create([
            'name' => $data['name'],
            'slug' => $data['slug'],
            'permissions' => $perms,
        ]);

        if (API_RESPONSE) {
            return response()->json([
                'status' => 'success',
                'message' => 'Role has been created',
                'data' => $role
            ]);
        }
        return redirect()->route('dashboard.role')->with('success', 'Role has been created');

    }






    public function edit($id) {

        // Check if the user has permission to get the page to update the roles
        $this->checkSinglePermission('roles.update.get');

        $role = Role::find($id);

        if (!$role) {
            if (API_RESPONSE) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Role not found'
                ], 404);
            }
            return redirect()->route('dashboard.role')->with('error', 'Role not found');
        }

        if ($role->id == Auth::user()->role->id) {
            session()->flash('warning', 'You are editing your own role. Please be carefull.');
        }

        return view('pages.account.role.manage', ['mode' => 'edit', 'role' => $role]);
    }

    public function update(Request $request, $id) {

        // Check if the user has permission to update the roles
        $this->checkSinglePermission('roles.update.post');

        $role = Role::find($id);

        if (!$role) {
            if (API_RESPONSE) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Role not found'
                ], 404);
            }
            return redirect()->route('dashboard.role')->with('error', 'Role not found');
        }

        $data = $request->only('name', 'slug', 'permissions');

        $validation = $this->validate($data, [
            'name' => 'required',
            'slug' => 'required|string|max:64|unique:roles,slug,' . $id,
            'permissions' => 'required|string|max:64000',
        ]);

        if ($validation['success'] == false) return $validation['redirect'];

        $perms = [];

        if (str_starts_with($data['permissions'], '{') || str_starts_with($data['permissions'], '[')) {
            $perms = json_decode($data['permissions'], true);
        } else if (str_starts_with($data['permissions'], 'a:')) {
            $perms = unserialize($data['permissions']);
        } else {
            if (API_RESPONSE) {
                return response()->json([
                    "status" => "error",
                    "code" => "invalid_permissions_format",
                ], 422);
            }
            return redirect()->route('dashboard.role')->with('error', 'Invalid permissions format')->withInput();
        }

        $role->update([
            'name' => $data['name'] ?? $role->name,
            'slug' => $data['slug'] ?? $role->slug,
            'permissions' => $perms ?? $role->permissions,
        ]);

        if (API_RESPONSE) {
            return response()->json([
                'status' => 'success',
                'message' => 'Role has been updated',
                'data' => $role
            ]);
        }
        return redirect()->route('dashboard.role')->with('success', 'Role has been updated');
    }






    public function trash($id) {

        // Check if the user has permission to get the page to delete roles
        $this->checkSinglePermission('roles.destroy.get');

        $role = Role::find($id);

        if (!$role) {
            if (API_RESPONSE) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Role not found'
                ], 404);
            }
            return redirect()->route('dashboard.role')->with('error', 'Role not found');
        }

        if ($role->id == Auth::user()->role->id) {
            if (API_RESPONSE) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'You can\'t delete your own role'
                ], 403);
            }
            return redirect()->route('dashboard.role')->with('error', 'You can\'t delete your own role');
        }

        return view('pages.account.role.manage', ['mode' => 'delete', 'role' => $role]);
    }

    public function destroy($id) {

        // Check if the user has permission to delete roles
        $this->checkSinglePermission('roles.destroy.post');

        $role = Role::find($id);

        if (!$role) {
            if (API_RESPONSE) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Role not found'
                ], 404);
            }
            return redirect()->route('dashboard.role')->with('error', 'Role not found');
        }

        if ($role->id == Auth::user()->role->id) {
            if (API_RESPONSE) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'You can\'t delete your own role'
                ], 403);
            }
            return redirect()->route('dashboard.role')->with('error', 'You can\'t delete your own role');
        }

        $role->delete();

        if (API_RESPONSE) {
            return response()->json([
                'status' => 'success',
                'message' => 'Role has been deleted'
            ]);
        }
        return redirect()->route('dashboard.role')->with('success', 'Role has been deleted');
    }

}
