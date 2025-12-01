<?php

namespace App\Http\Controllers;

use App\Events\UserVerified;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\User;

class VerifyController extends Controller {

    public function notice() {
        if (Auth::check() && Auth::user()->hasVerifiedEmail()) {
            // If the user is already verified, redirect to profile
            return redirect()->route('profile')->with('info', 'Your email is already verified.');
        }

        return view('pages.auth.verify-email');
    }

    public function verify(Request $request) {
        if (!Auth::check()) {
            // If the user is not authenticated, redirect to login
            return redirect()->route('login')->with('error', 'Please login first then click the link again.');
        }

        // Check if the user has permission to verify email
        $this->checkSinglePermission('verify.post');

        if (Auth::check() && Auth::user()->hasVerifiedEmail()) {
            // If the user is already verified, redirect to profile
            return redirect()->route('profile')->with('info', 'Your email is already verified.');
        }

        // Manually verify the signature and user ID
        if (!hash_equals($request->route('id'), (string) Auth::user()->id)) {
            return redirect()->route('login')->with('error', 'Invalid verification link.');
        }

        if (!hash_equals($request->route('hash'), sha1(Auth::user()->email))) {
            return redirect()->route('login')->with('error', 'Invalid verification link.');
        }

        // Mark email as verified
        if (!Auth::user()->hasVerifiedEmail()) {
            Auth::user()->markEmailAsVerified();
            event(new UserVerified(Auth::user()));
        }

        return redirect()->route('profile')->with('success', 'Email verified successfully!');
    }

    public function send(Request $request) {
        if (Auth::check() && Auth::user()->hasVerifiedEmail()) {
            // If the user is already verified, redirect to profile
            return redirect()->route('profile')->with('info', 'Your email is already verified.');
        }

        // Check if the user has permission to resend verification email
        $this->checkSinglePermission('verify.get');

        $data = $request->only('g-recaptcha-response');

        $validation = $this->validate($data, [
            'g-recaptcha-response' => 'required|recaptchav3:verify',
        ]);

        if ($validation['success'] == false) return $validation['redirect'];

        $request->user()->sendEmailVerificationNotification();
        return back()->with('info', 'Verification link resent!');
    }
}
