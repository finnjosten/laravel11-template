<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Ramsey\Uuid\Uuid as UUID;

class AuthController extends Controller
{

    public function register()
    {
        return view('pages.auth.register');
    }

    public function registerPost(Request $request) {

        // Validate the request
        try {
            $validated = $request->validate([
                'name' => 'required',
                'email' => 'required|email|unique:users',
                'password' => 'required',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->with('error', 'A field did not meet the requirements')->withInput();
        }

        // Clear any previous errors
        $request->session()->forget(['errors', 'success', 'info', 'warning']);

        $data = [
            'name' => $validated['name'],
            'uuid' => UUID::uuid4()->toString(),
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'admin' => null,
            'blocked' => null,
            'verified' => null,
        ];

        // Create the user
        $user = User::create($data);

        // Redirect to the login page
        return redirect()->route('login')->with('success', 'Registration successful');
    }



    public function login()
    {
        return view('pages.auth.login');
    }

    public function loginPost(Request $request) {

        // Validate the request
        try {
            $validated = $request->validate([
                'email' => 'required|email',
                'password' => 'required',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->with('error', 'A field did not meet the requirements')->withInput();
        }

        // Clear any previous errors
        $request->session()->forget(['errors', 'success', 'info', 'warning']);

        // Attempt to authenticate the user
        if (Auth::attempt($validated)) {
            // Redirect to the dashboard

            if($request->query('return')) {
                return redirect(urldecode($request->query('return')))->with('success', 'Login successful');
                exit();
            }
            return redirect()->route('dashboard.main')->with('success', 'Login successful');
            exit();
        }

        // Authentication failed, redirect back with error message
        return redirect()->back()->with('error', 'Email or password is incorrect')->withInput();
    }


    public function logout()
    {
        // Log the user out
        auth()->logout();
        return redirect()->route('login')->with('success', 'Logout successful');
    }
}
