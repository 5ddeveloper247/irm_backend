<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Membership;
class MembershipController extends Controller
{
    //saveMembership
    public function saveMembership(Request $request){
        // validate the request
        $request->validate([
            'username' => 'required',
            'email' => 'required|email',
            'phone' => 'required|numeric|digits_between:7,15',
            'city' => 'required',
            'country' => 'required',
            'message' => 'required',
        ]);
        $membership = new Membership();
        $membership->username = $request->username;
        $membership->email = $request->email;
        $membership->phone = $request->phone;
        $membership->city = $request->city;
        $membership->country_id = $request->country;
        $membership->message = $request->message;
        $membership->save();
        return response()->json(['message' => 'Membership saved successfully'], 200);
    }
}
