<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;
use Illuminate\Support\Facades\Validator;

class ContactController extends Controller {

    /** Data functions **/

    public function index() {
        $contacts = Contact::all();

        if (API_RESPONSE) {
            return response()->json([
                'status' => 'success',
                'data' => $contacts
            ]);
        }
        return view('pages.account.contact.index');
    }

    public function show($id) {
        $contact = Contact::find($id);
        if (!$contact) {
            if (API_RESPONSE) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Contact message not found'
                ], 404);
            }
            return redirect()->route('dashboard.contact')->with('error', 'Contact message not found');
        }

        if (API_RESPONSE) {
            return response()->json([
                'status' => 'success',
                'data' => $contact
            ]);
        }
        return view('pages.account.contact.manage', ['mode' => 'view', 'contact' => $contact]);
    }



    public function view($id) {
        $contact = Contact::findOrFail($id);
        return view('pages.account.contact.manage', ['mode' => 'view', 'contact' => $contact]);
    }



    public function create() {
        return view('pages.contact');
    }

    public function store(Request $request) {
        $data = $request->only('email', 'subject', 'content');

        $this->validate($data, [
            'email' => 'required',
            'subject' => 'required',
            'content' => 'required',
        ]);

        // Create the contact message
        $contact = Contact::create([
            'email' => $data['email'],
            'subject' => $data['subject'],
            'content' => $data['content'],
        ]);

        if (API_RESPONSE) {
            return response()->json([
                'status' => 'success',
                'message' => 'Message has been sent',
                'data' => $contact
            ]);
        }
        return redirect()->route('home')->with('success', 'Message has been sent');
    }



    public function trash($id) {
        $contact = Contact::findOrFail($id);
        return view('pages.account.contact.manage', ['mode' => 'delete', 'contact' => $contact]);
    }

    public function destroy($id) {
        $contact = Contact::find($id);
        if (!$contact) {
            if (API_RESPONSE) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Contact message not found'
                ], 404);
            }
            return redirect()->route('dashboard.contact')->with('error', 'Contact message not found');
        }

        $contact->delete();

        if (API_RESPONSE) {
            return response()->json([
                'status' => 'success',
                'message' => 'Message has been deleted'
            ]);
        }
        return redirect()->route('dashboard.contact')->with('success', 'Message has been deleted');
    }

}
