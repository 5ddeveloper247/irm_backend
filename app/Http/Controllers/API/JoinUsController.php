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
        return response()->json(['status' => 200, 'message' => 'Join Us saved successfully']);
    }
}
