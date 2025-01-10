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
        $data['join_list'] = JoinUs::all();
        return response()->json(['status' => 200, 'data' => $data]);  
    }
}
