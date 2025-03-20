<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Youtube;
class YoutubeController extends Controller
{
    //youtube
    public function youtube()
    {
        return view('admin.youtube');
    }
    // getYoutubePageData
    public function getYoutubePageData()
    {
        // $youtubes = Youtube::orderBy('id', 'desc')->get();
        $query = Youtube::orderBy('id', 'desc')->latest();
        // playlist_id: 
        if(request()->has('playlist_id') && request('playlist_id') != ''){
            if (request()->filled('playlist_id')) {
                $query->where('playlist_id', 'like', '%'.request('playlist_id').'%');
            }
        }
        // playlist_title: 
        if(request()->has('playlist_title') && request('playlist_title') != ''){
            $query->where('playlist_title', 'like', '%'.request('playlist_title').'%');
        }
        // status: where in
        if(request()->has('status') && request('status') != ''){
            $query->where('status', request('status'));
        }
        $youtubes = $query->get();
        return response()->json(['youtubes_list' => $youtubes, 'status' => 200]);
    }
    // saveYoutube
    public function saveYoutube(Request $request)
    {
        $request->validate([
            'playlist_id' => 'required',
            'playlist_title' => 'required',
            'status' => 'required',
        ]);
        // check youtube_id is available then edit it
        if ($request->youtube_id != '') {
            $youtube = Youtube::find($request->youtube_id);
        }else{
            $youtube = new Youtube();
        }
        $youtube->playlist_id = $request->playlist_id;
        $youtube->playlist_title = $request->playlist_title;
        $youtube->status = $request->status;
        $youtube->save();
        return response()->json(['message' => 'Youtube saved successfully', 'status' => 200]);
    }
    // getSpecificYoutube
    public function getSpecificYoutube(Request $request,)
    {
        $youtube = Youtube::find($request->youtube_id);
        return response()->json(['youtube' => $youtube, 'status' => 200]);
    }
    // deleteYoutubePlaylist
    public function deleteYoutubePlaylist(Request $request)
    {
        $youtube = Youtube::find($request->youtube_id);
        $youtube->delete();
        return response()->json(['message' => 'Youtube deleted successfully', 'status' => 200]);
    }
}
