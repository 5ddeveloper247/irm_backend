<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Contact;
use App\Models\User;

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
        try{
            // send email to admin get admin data from user table
            $admin = User::where('role', 1)->first();
            $to_name = $admin->name;
            $to_email = $admin->email;
            $subject = $request->subject;
            $message = $request->message; 
            sendMail($to_name, $to_email, $subject, $message);
            // send email to user for confirmation
            $to_name = $request->name;
            $to_email = $request->email;
            $subject = 'Contact Confirmation';
            $message = 'Thank you for contacting us. We will get back to you soon.';
            sendMail($to_name, $to_email, $subject, $message);
        }catch(\Exception $e){
            return response()->json(['message' => 'Contact saved successfully but email not sent'], 200);
        }
        return response()->json(['message' => 'Contact saved successfully'], 200);
    }
}
