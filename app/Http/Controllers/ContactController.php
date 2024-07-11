<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;
use COM;

class ContactController extends Controller
{

    public function create() {
        return view('pages.contact');
    }

    public function view(Contact $contact) {
        return view('pages.account.contact-edit', ['mode' => 'view', 'contact' => $contact]);
    }

    public function trash(Contact $contact) {
        return view('pages.account.contact-edit', ['mode' => 'delete', 'contact' => $contact]);
    }


    public function add(Request $request) {

        // Validate the request
        try {
            $validated = $request->validate([
                'email' => 'required',
                'subject' => 'required',
                'content' => 'required',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->with('error', 'A field did not meet the requirements')->withInput();
        }

        // Clear any previous errors
        $request->session()->forget(['errors', 'success', 'info', 'warning']);

        // Create the contact message
        $contact = Contact::create([
            'email' => $validated['email'],
            'subject' => $validated['subject'],
            'content' => $validated['content'],
        ]);

        return redirect()->route('home')->with('success', 'Message has been sent');

    }

    public function delete(Contact $contact) {

        $contact->delete();

        return redirect()->route('dashboard.contact')->with('success', 'Message has been deleted');

    }

}
