<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Contact;
class ContactController extends Controller
{
    //saveContact
    public function saveContact(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            // add phone validation
            'phone' => 'required|numeric|digits_between:7,15',
            'subject' => 'required',
            'message' => 'required',
        ]);
        
        $contact = new Contact();
        $contact->name = $request->name;
        $contact->email = $request->email;
        $contact->phone = $request->phone;
        $contact->subject = $request->subject;
        $contact->message = $request->message;
        $contact->save();
        return response()->json(['message' => 'Contact saved successfully'], 200);
    }
}
