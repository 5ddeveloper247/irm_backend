<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Membership;
class MembershipController extends Controller
{
    // memberships
    public function memberships(){
        return view('admin.memberships');
    }
    // getMembershipsPageData
    public function getMembershipsPageData(Request $request){
        $query = Membership::with('country')->orderBy('id', 'desc');
        // name use has request
        if($request->name){
            $query->where('username', 'like', '%'.$request->name.'%');
        }
        // email use has request
        if($request->email){
            $query->where('email', 'like', '%'.$request->email.'%');
        }
        // phone use has request
        if($request->phone){
            $query->where('phone', 'like', '%'.$request->phone.'%');
        }
        // city use has request
        if($request->city){
            $query->where('city', 'like', '%'.$request->city.'%');
        }
        // date 2025-02-12
        if($request->date){
            // use date 2025-02-12
            $query->whereDate('created_at', $request->date);
        }
        $memberships['memberships_list'] = $query->get();
        // email: ew
        // phone: 332323
        // city: 
        // country: 
        // date: 
        // $memberships['memberships_list'] = Membership::with('country')->orderBy('id', 'desc')->get();
        return response()->json(['status' => 200, 'data' => $memberships]);
    }
    // viewMember
    public function viewMember(Request $request){
        $member = Membership::with('country')->where('id', $request->id)->first();
        return response()->json(['status' => 200, 'data' => $member]);
    }
}
