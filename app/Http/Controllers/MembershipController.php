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
        $memberships['memberships_list'] = Membership::with('country')->orderBy('id', 'desc')->get();
        return response()->json(['status' => 200, 'data' => $memberships]);
    }
}
