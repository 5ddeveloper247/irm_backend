<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WorkLocation;
class WorkLocationController extends Controller
{
    // getSpecificWorklocation
    public function getSpecificWorklocation(Request $request){
        $worklocation = WorkLocation::find($request->worklocation_id);
        return response()->json(['status' => 200, 'worklocation' => $worklocation]);
    }
    // getWorklocationPageData
    public function getWorklocationPageData(Request $request){
        // $worklocations = WorkLocation::where('status', 1)->latest()->get();
        $query = WorkLocation::where('status', 1)->latest();
        // title: 
        if(request()->has('title') && request('title') != ''){
            $query->where('title', 'like', '%'.request('title').'%');
        }
        // status: 
        if(request()->has('status') && request('status') != ''){
            $query->where('status', request('status'));
        }
        // date: 
        if(request()->has('date') && request('date') != ''){
            $query->whereDate('created_at', request('date'));
        }
        $worklocations = $query->get();
        return response()->json(['status' => 200, 'worklocations_list' => $worklocations]);
    }
    //worklocation
    public function worklocation(){
        return view('admin.worklocation');
    }
    // saveWorklocation
    public function saveWorklocation(Request $request){
        // dd($request->all());
        $request->validate([
            'title' => 'required',
            'lat' => 'required',
            'lng' => 'required',
            'color' => 'required',
            'descriptions' => 'required',
        ]);
        
        if($request->worklocation_id!='' && $request->worklocation_id!=null && $request->worklocation_id>0){
            $worklocation = WorkLocation::find($request->worklocation_id);
        }else{
            $worklocation = new WorkLocation();
        }
        $worklocation->title = $request->title;
        $worklocation->lat = $request->lat;
        $worklocation->lng = $request->lng;
        $worklocation->color = $request->color;
        $worklocation->descriptions = $request->descriptions;
        $worklocation->save();
        return response()->json(['status' => 200, 'message' => 'Work Location saved successfully']);
    }
    // deleteWorklocation
    public function deleteWorklocation(Request $request){
        $worklocation = WorkLocation::find($request->worklocation_id);
        $worklocation->delete();
        return response()->json(['status' => 200, 'message' => 'Work Location deleted successfully']);
    }
}
