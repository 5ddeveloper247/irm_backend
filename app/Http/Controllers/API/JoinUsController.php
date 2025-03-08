<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\JoinUs;
class JoinUsController extends Controller
{
    //saveJoinUs
    public function saveJoinUs(Request $request)
    {
        // change message validation text
        $customMessages = [
            'message.required' => 'The Description field is required.',
        ];
        $validated = $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required|numeric|digits_between:7,15',
            'subject' => 'required',
            'message' => 'required',
        ], $customMessages);
        $join_us = new JoinUs();
        $join_us->name = $request->name;
        $join_us->email = $request->email;
        $join_us->phone = $request->phone;
        $join_us->subject = $request->subject;
        $join_us->message = $request->message;
        $join_us->save();
        // send email
        $data = array(
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'subject' => $request->subject,
            'message' => $request->message,
        );
        $tags = ["@@name@@", "@@email@@", "@@phone@@", "@@subject@@", "@@message@@"];
        $template = "Hello @@name@@, <br><br> Your message has been received. We will get back to you soon. <br><br> Regards, <br> Team";
        // subject add tags
        $subject = "Join Us - @@name@@";
        $subject = str_replace($tags, $data, $subject);
        // message add tags
        $template = str_replace($tags, $data, $template);
        try{
            sendMail($request->name, $request->email, $subject, $template);
        }catch(\Exception $e){
            return response()->json(['status' => 500, 'message' => 'Something went wrong. Please try again later.']);
        }
        return response()->json(['status' => 200, 'message' => 'Join Us saved successfully']);
    }
}
