<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class ResetController extends Controller {

    public function request() {

        // Check if the user has permission to view the password reset request page
        $this->checkGuestPermission('password.request.get');

        return view('pages.auth.password-request');
    }

    public function requestPost(Request $request) {

        // Check if the user has permission to submit the password reset request
        $this->checkGuestPermission('password.request.post');

        $data = $request->only('email', 'g-recaptcha-response');

        $validation = $this->validate( $data, [
            'email' => 'required|email',
            'g-recaptcha-response' => 'required|recaptchav3:password',
        ]);

        if ($validation['success'] == false) return $validation['redirect'];

        $status = Password::sendResetLink(['email' => $data['email']]);

        return $status === Password::ResetLinkSent ? back()->with('success', __($status)) : back()->with('error', __($status));

    }



    public function reset($token) {

        // Check if the user has permission to view the password reset page
        $this->checkGuestPermission('password.reset.get');

        return view('pages.auth.password-reset', ['token' => $token, 'email' => request()->get('email')]);
    }

    public function resetPost(Request $request) {

        // Check if the user has permission to submit the password reset
        $this->checkGuestPermission('password.reset.post');

        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );

        return $status === Password::PasswordReset ? redirect()->route('login')->with('success', __($status)) : back()->with('error', __($status));
    }
}
