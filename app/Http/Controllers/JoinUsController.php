<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JoinUs;
class JoinUsController extends Controller
{
    //joinUs
    public function joinUs()
    {
        return view('admin.join_us');
    }
    // getJoinUsPageData
    public function getJoinUsPageData()
    {
        // $data['join_list'] = JoinUs::all();
        $query = JoinUs::latest();
        // name: ds
        if (request()->has('name') && request('name') != '') {
            $query->where('name', 'like', '%' . request('name') . '%');
        }
        // email: ds
        if (request()->has('email') && request('email') != '') {
            $query->where('email', 'like', '%' . request('email') . '%');
        }
        // phone: ds
        if (request()->has('phone') && request('phone') != '') {
            $query->where('phone', 'like', '%' . request('phone') . '%');
        }
        // subject: ds
        if (request()->has('subject') && request('subject') != '') {
            $query->where('subject', 'like', '%' . request('subject') . '%');
        }
        // created_at: date
        if (request()->has('created_at') && request('created_at') != '') {
            $query->whereDate('created_at', request('created_at'));
        }
        $data['join_list'] = $query->get();
        // email: 
        // phone: 
        // subject: 
        // created_at: 
        return response()->json(['status' => 200, 'data' => $data]);  
    }
}
