<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Membership;
use App\Models\Country;
use Illuminate\Support\Facades\Validator;

class MembershipController extends Controller
{
    // memberships
    public function memberships(){
        $countries = Country::orderBy('name', 'asc')->get();
        return view('admin.memberships', compact('countries'));
    }
    
    // getMembershipsPageData
    public function getMembershipsPageData(Request $request){
        $query = Membership::with('country')->orderBy('id', 'desc');
        
        // Filter by name
        if($request->has('name') && $request->name != ''){
            $query->where('username', 'like', '%'.$request->name.'%');
        }
        
        // Filter by email
        if($request->has('email') && $request->email != ''){
            $query->where('email', 'like', '%'.$request->email.'%');
        }
        
        // Filter by phone
        if($request->has('phone') && $request->phone != ''){
            $query->where('phone', 'like', '%'.$request->phone.'%');
        }
        
        // Filter by city
        if($request->has('city') && $request->city != ''){
            $query->where('city', 'like', '%'.$request->city.'%');
        }
        
        // Filter by country
        if($request->has('country') && $request->country != ''){
            $query->whereHas('country', function($q) use ($request) {
                $q->where('name', 'like', '%'.$request->country.'%');
            });
        }
        
        // Filter by date
        if($request->has('date') && $request->date != ''){
            $query->whereDate('created_at', $request->date);
        }
        
        $query->limit(10000);
        $memberships['memberships_list'] = $query->get();
        
        return response()->json(['status' => 200, 'data' => $memberships]);
    }
    
    // viewMember
    public function viewMember(Request $request){
        $member = Membership::with('country')->where('id', $request->id)->first();
        
        if(!$member){
            return response()->json(['status' => 404, 'message' => 'Member not found']);
        }
        
        return response()->json(['status' => 200, 'data' => $member]);
    }

    // saveMembership
    public function saveMembership(Request $request)
    {
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|max:100',
            'email' => 'required|email|max:100|unique:memberships,email,' . $request->membership_id,
            'phone' => 'required|string|max:20',
            'country_id' => 'required|exists:countries,id',
            'city' => 'required|string|max:100',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'message' => $validator->errors()->first()
            ]);
        }

        try {
            if ($request->membership_id) {
                $membership = Membership::find($request->membership_id);
                if (!$membership) {
                    return response()->json(['status' => 404, 'message' => 'Membership not found']);
                }
            } else {
                $membership = new Membership();
            }

            $membership->username = $request->username;
            $membership->email = $request->email;
            $membership->phone = $request->phone;
            $membership->country_id = $request->country_id;
            $membership->city = $request->city;
            $membership->save();

            $message = $request->membership_id ? 'Membership Updated Successfully' : 'Membership Added Successfully';
            return response()->json(['status' => 200, 'message' => $message]);
            
        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => 'Something went wrong: ' . $e->getMessage()
            ]);
        }
    }
}