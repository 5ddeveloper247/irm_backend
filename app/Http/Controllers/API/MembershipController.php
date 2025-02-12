<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Membership;
class MembershipController extends Controller
{
    //saveMembership
    public function saveMembership(Request $request){
        // return response()->json($request->all(), 200);   
        // validate the request
        $request->validate([
            // 'username' => 'required',
            'email' => 'required|email',
            'mobileNumber' => 'required|numeric|digits_between:7,15',
            'city' => 'required',
            'country' => 'required',
            'message' => 'required',

        ]);
        // formType = active
        if($request->formType == 'active'){
            $request->validate([
                'cnicNumber' => 'required|numeric',
                'dateOfBirth' => 'required|date',
                'district' => 'required',
                'education' => 'required',
                'fatherName' => 'required',
                'formType' => 'required',
                'fullName' => 'required',
                'gender' => 'required',
                
                'permanentAddress' => 'required',
                'presentAddress' => 'required',
                'province' => 'required',
                'tehsil' => 'required',
                'whatsappNumber' => 'required|numeric|digits_between:7,15',
            ]);
        }
        $membership = new Membership();
        // $membership->username = $request->username;
        $membership->email = $request->email;
        $membership->phone = $request->mobileNumber;
        $membership->city = $request->city;
        $membership->country_id = $request->country;
        $membership->message = $request->message;
        $membership->cnic_number = $request->cnicNumber;
        $membership->date_of_birth = $request->dateOfBirth;
        $membership->district = $request->district;
        $membership->education = $request->education;
        $membership->father_name = $request->fatherName;
        $membership->membership_type = $request->formType;
        $membership->username = $request->fullName;
        $membership->gender = $request->gender;
        // $membership->mobile_number = $request->mobileNumber;
        $membership->permanent_address = $request->permanentAddress;
        $membership->present_address = $request->presentAddress;
        $membership->province = $request->province;
        $membership->tehsil = $request->tehsil;
        $membership->whatsapp_number = $request->whatsappNumber;
        $membership->save();
        return response()->json(['message' => 'Membership saved successfully'], 200);
    }
}
