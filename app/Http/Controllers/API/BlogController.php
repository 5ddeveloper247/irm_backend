<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Blog;
class BlogController extends Controller
{
    
    public function getBlogs(Request $request)
    {
        // blogs published_date and end_date
        $data['blog_list'] = Blog::where('published_date', '<=', date('Y-m-d'))->where('end_date', '>=', date('Y-m-d'))
        // add status condition = 1
        ->where('status', 1)
        ->get();
        // set base url on image
        foreach($data['blog_list'] as $key => $value){
            // published_date convert 08 Mar 2025
            $data['blog_list'][$key]->published_date = \Carbon\Carbon::parse($value->published_date)->format('d M Y');
            // remove description tags and show 30 characters
            $data['blog_list'][$key]->description = substr(strip_tags($value->description), 0, 110);
            $data['blog_list'][$key]->image = url('/'.$value->thumbnail);
        }
        return response()->json(['status' => 200, 'message' => "", 'data' => $data]);
    }
    public function getSpecificBlog(Request $request, $id)
    {
        $data['blog_detail'] = Blog::where('id', $id)->first();
        // set base url on image
        $data['blog_detail']->image = url('/'.$data['blog_detail']->thumbnail);
        // created_at to human readable
        $data['blog_detail']->created_at2 = $data['blog_detail']->created_at->diffForHumans();
        return response()->json(['status' => 200, 'message' => "", 'data' => $data]);
    }
}
