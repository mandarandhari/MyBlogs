<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Contact;
use App\Mail\ContactUs;
use App\Mail\ContactUsAdmin;

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
            Mail::to($request->email)
                ->send(new ContactUs($contact));
                //To send mails in queue, replace send() with queue()

            Mail::to('admin@myblogs.com')
                ->send(new ContactUsAdmin($contact));
                //To send mails in queue, replace send() with queue()

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
