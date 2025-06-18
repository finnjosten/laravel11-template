<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;
use Ramsey\Uuid\Uuid as UUID;

class AuthController extends Controller {

    /** Data functions **/

    public function register() {
        return view('pages.auth.register');
    }

    public function registerPost(Request $request) {
        $data = $request->only('name', 'email', 'password');

        $this->validate($data, [
            'name' => 'required|unique:users,name',
            'email' => 'required|email|unique:users',
            'password' => 'required',
        ]);

        $data['uuid'] = UUID::uuid4()->toString();
        $data['admin'] = null;
        $data['blocked'] = null;
        $data['verified'] = null;

        // Create the user
        $user = User::create($data);

        // Redirect to the login page
        if (API_RESPONSE) {
            return response()->json([
                'status' => "success",
                'message' => "Registration successful",
            ]);
        }
        return redirect()->route('login')->with('success', 'Registration successful');
    }



    public function login() {
        return view('pages.auth.login');
    }

    public function loginPost(Request $request) {
        $data = $request->only('email', 'password');

        $this->validate($data, [
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        // Attempt to authenticate the user
        if (Auth::attempt($data)) {

            // Check if the user is blocked
            if (Auth::user()->blocked) {
                if (API_RESPONSE) {
                    return response()->json([
                        'status' => "error",
                        'message' => "User is blocked",
                    ], 401);
                }
                return redirect()->back()->with('error', 'Your account is blocked')->withInput();
            }
            // Check if the user is verified
            if (Auth::user()->verified == null) {

                if (API_RESPONSE) {
                    return response()->json([
                        'status' => "error",
                        'message' => "User is not verified",
                    ], 401);
                }
                return redirect()->back()->with('error', 'Your account is not verified')->withInput();
            }

            if (API_RESPONSE) {
                // Limit users to only one session at a time
                /* if (Auth::user()->tokens()->count() > 0) {
                    Auth::user()->tokens()->delete();
                } */

                $token = Auth::user()->createToken('authToken', ['*'], now()->addDay())->plainTextToken;

                return response()->json([
                    'success' => true,
                    'access_token' => $token,
                    'token_type' => 'Bearer',
                ]);
            }

            return redirect()->route('dashboard.main')->with('success', 'Login successful');
        }

        // Authentication failed, redirect back with error message
        if (API_RESPONSE) {
            return response()->json([
                'status' => "error",
                'message' => "Invalid credentials",
            ], 401);
        }
        return redirect()->back()->with('error', 'Email or password is incorrect')->withInput();
    }



    public function logout() {
        if (!Auth::check()) {
            if (API_RESPONSE) {
                return response()->json([
                    'status' => "error",
                    'message' => "You are not logged in",
                ], 401);
            } else {
                return redirect()->route('login')->with('error', 'You are not logged in');
            }
        }

        // Revoke all the access tokens
        Auth::user()->tokens()->delete();

        // Logout the user
        if (request()->hasSession()) {
            request()->session()->invalidate();
            request()->session()->regenerateToken();
        }

        // Respond
        if (API_RESPONSE) {
            return response()->json([
                'status' => "success",
                'message' => "Logout successful",
            ]);
        }

        // Log the user out
        Auth::logout();
        return redirect()->route('login')->with('success', 'Logout successful');
    }



    public function reset() {
        return view('pages.auth.reset-pass');
    }

    public function resetPost(Request $request) {
        return response()->json([
            'status' => 'error',
            'message' => 'This endpoint is not implemented yet.',
        ], 501);


        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink( $request->only('email') );

        //dd($status);

        return null; //$status === Password::ResetLinkSent ? back()->with(['status' => __($status)]) : back()->withErrors(['email' => __($status)]);
    }
}
