<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Contact;

class ContactController extends Controller
{
    public function add_contact(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'phone' => ['required', 'string', 'max:255'],
            'message' => ['required', 'max:1000']
        ]);

        $contact = new Contact;

        $contact->name = $request->name;
        $contact->email = $request->email;
        $contact->phone = $request->phone;
        $contact->message = $request->message;

        if ($contact->save()) {
            return response()->json([
                'success' => TRUE,
                'message' => 'Your message has been sent.'
            ]);
        } else {
            return response()->json([
                'success' => FALSE,
                'message' => "Sorry " . $request->name . ", it seems that my mail server is not responding. Please try again later!"
            ]);
        }
    }
}
