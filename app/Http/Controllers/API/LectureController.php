<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AudioCategory;
use App\Models\AudioLecture;
use App\Models\AudioLectureAttachment;
use Carbon\Carbon;

class LectureController extends Controller
{
    // get lectures
    public function getLectures(Request $request, $categoryId = 0)
    {
        // get query string
        $search = $request->query('search');
        // get all lectures with category with attachments and where status = 1
        // when categoryId = 0 then get all lectures
        $query = AudioLecture::with('category', 'attachments')
            ->where('status', 1);

        if ($categoryId != 0) {
            $query->where('category_id', $categoryId);
        }

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', '%' . $search . '%')
                    ->orWhere('duration', 'like', '%' . $search . '%');
            });
        }

        $data['lecture_list'] = $query->orderBy('duration', 'desc')->get();
        // set base url on image
        foreach ($data['lecture_list'] as $key => $value) {
            $data['lecture_list'][$key]->thumbnail = url('/' . $value->thumbnail);
        }
        // set base url on attachment
        foreach ($data['lecture_list'] as $key => $value) {
            foreach ($value->attachments as $key1 => $value1) {
                $data['lecture_list'][$key]->attachments[$key1]->attachment = url('/' . $value1->path);
            }
        }
        // get category_list and status = 1
        $data['category_list'] = AudioCategory::where('status', 1)->get();
        return response()->json(['status' => 200, 'message' => "", 'data' => $data]);
    }
    // get specific lecture
    public function getSpecificLecture(Request $request, $id)
    {
        $data['lecture_detail'] = AudioLecture::with('category', 'attachments')->where('id', $id)->first();
        $data['lecture_detail']->release_date = date('F d Y', strtotime($data['lecture_detail']->created_at));
        // set base url on image
        $data['lecture_detail']->thumbnail = url('/' . $data['lecture_detail']->thumbnail);
        // set base url on attachment
        foreach ($data['lecture_detail']->attachments as $key => $value) {
            $data['lecture_detail']->attachments[$key]->attachment = url('/' . $value->path);
        }
        // get 3 related lectures
        $data['related_lectures'] = AudioLecture::with('category', 'attachments')->where('status', 1)->where('category_id', $data['lecture_detail']->category_id)->where('id', '!=', $id)->limit(3)->get()->map(function ($lecture) {
            $lecture->thumbnail = url('/' . $lecture->thumbnail);
            // release_date
            $lecture->release_date = date('F d Y', strtotime($lecture->created_at));
            return $lecture;
        });
        return response()->json(['status' => 200, 'message' => "", 'data' => $data]);
    }
    // get specific lecture with category
    public function getCategory(Request $request)
    {
        // get category_list and status = 1
        $data['category_list'] = AudioCategory::where('status', 1)->get();
        return response()->json(['status' => 200, 'message' => "", 'data' => $data]);
    }
    // get 4 lastest audio Categories with two audio lectures
    public function getAudioCategoriesWithAudioLectures(Request $request)
    {
        // get 4 latest categories with status = 1
        $categories = AudioCategory::where('status', 1)->orderBy('id', 'desc')->take(4)->get();

        // get 2 audio lectures with each category
        $categories->each(function ($category) {
            $category->lectures = AudioLecture::where('category_id', $category->id)
                ->where('status', 1)
                ->limit(2)
                ->get()
                ->each(function ($lecture) {
                    $lecture->thumbnail = url('/' . $lecture->thumbnail);
                });
        });

        return response()->json(['status' => 200, 'message' => "", 'data' => ['category_list' => $categories]]);
    }
}
