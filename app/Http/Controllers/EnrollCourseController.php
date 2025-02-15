<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EnrollCourse;
use Illuminate\Support\Facades\Validator;
use App\Models\Course;
// APIYoutubeController
use App\Http\Controllers\API\YoutubeController as APIYoutubeController;
class EnrollCourseController extends Controller
{
    // updateCourseViewIndex users table
    public function updateCourseViewIndex(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'course_id' => 'required',
            // view_index
            'view_index' => 'required|numeric|min:0'
        ]);
        if ($validate->fails()) {
            return response()->json([
                'message' => 'Validation Error',
                'errors' => $validate->errors()
            ], 422);
        }
        auth()->user()->course_view_index = $request->view_index;
        auth()->user()->save();
        return response()->json([
            'message' => 'Course View Index Updated Successfully',
            'data' => auth()->user()
        ], 200);
    }
    // enrollCourses
    public function enrollCourses(){
        return view('admin.enrollcourses');
    }
    // getAllEnrollCourse
    public function getEnrollCoursesPageData()
    {
        // $data['enrollCourse_list'] = EnrollCourse::with('course')->orderBy('id','desc')->get();
        $query = EnrollCourse::with('course')->orderBy('id','desc')->latest();
        // name: 
        if(request()->has('name') && request('name') != ''){
            $query->where('name', 'like', '%'.request('name').'%');
        }
        // email: 
        if(request()->has('email') && request('email') != ''){
            $query->where('email', 'like', '%'.request('email').'%');
        }
        // course_title: 
        if(request()->has('course_title') && request('course_title') != ''){
            $query->whereHas('course', function($query){
                $query->where('title', 'like', '%'.request('course_title').'%');
            });
        }

        // instructor_name: 
        if (request()->has('instructor_name') && request('instructor_name') != '') {
            $instructorNames = explode(',', request('instructor_name'));
        
            // Ensure each name is trimmed properly
            $instructorNames = array_map('trim', $instructorNames);
        
            $query->whereHas('course', function ($query) use ($instructorNames) {
                foreach ($instructorNames as $instructorName) {
                    $query->where('instructor_name', 'like', '%' . $instructorName . '%');
                }
            });
        }
        
        // level: 
        if(request()->has('level') && request('level') != ''){
            $query->whereHas('course', function($query){
                $query->where('level', request('level'));
            });
        }
        // date: 
        if(request()->has('date') && request('date') != ''){
            $query->whereDate('created_at', request('date'));
        }
        $data['enrollCourse_list'] = $query->get();
        return response()->json(['status' => 200, 'message' => "", 'data' => $data]);
        
    }
    // enroll course
    public function enrollCourse(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'course_id' => 'required',
        ]);
        if ($validate->fails()) {
            return response()->json([
                'message' => 'Validation Error',
                'errors' => $validate->errors()
            ], 422);
        }
        // check if user already enrolled in the course
        $isEnrollCourse = EnrollCourse::where('course_id', $request->course_id)->where('user_id', auth()->user()->id)->first();
        if ($isEnrollCourse) {
            return response()->json([
                'message' => 'You have already enrolled in this course'
            ], 400);
        }
        $enrollCourse = new EnrollCourse();
        $enrollCourse->course_id = $request->course_id;
        $enrollCourse->user_id = auth()->user()->id;
        // 
        $enrollCourse->save();
        return response()->json([
            'message' => 'Course Enrolled Successfully',
            'data' => $enrollCourse
        ], 201);
    }
    // enrollCourseWithUserDetail
    public function enrollCourseWithUserDetail(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'course_id' => 'required',
            'address' => 'required',
            'email' => 'required|email',
            'name' => 'required',
            'phone' => 'required',
        ]);
        if ($validate->fails()) {
            return response()->json([
                'message' => 'Validation Error',
                'errors' => $validate->errors()
            ], 422);
        }
        // return response()->json([
        //     'message' => 'Course Enrolled Successfully',
        //     'data' => $request->all()
        // ], 201);
        // check if user already enrolled in the course
        $isEnrollCourse = EnrollCourse::where('course_id', $request->course_id)->where('user_id', auth()->user()->id)->first();
        if ($isEnrollCourse) {
            return response()->json([
                'message' => 'You have already enrolled in this course'
            ], 400);
        }
        $enrollCourse = new EnrollCourse();
        $enrollCourse->course_id = $request->course_id;
        $enrollCourse->user_id = auth()->user()->id;
        $enrollCourse->address = $request->address;
        $enrollCourse->email = $request->email;
        $enrollCourse->name = $request->name;
        $enrollCourse->phone = $request->phone;
        $enrollCourse->save();
        return response()->json([
            'message' => 'Course Enrolled Successfully',
            'data' => $enrollCourse
        ], 201);
    }
    // getMyCourses
    public function getMyCourses()
    {
        $myCourses = EnrollCourse::where('user_id', auth()->user()->id)->with('course')->get()->map(function ($enrollCourse) {
            // course image baseurl
            $enrollCourse->course->image = url('/' . $enrollCourse->course->thumbnail);
            // cut the description
            $enrollCourse->course->description = substr($enrollCourse->course->description, 0, 100);
            // course map and set instructor_name_list with comma separated
            $enrollCourse->course->instructor_name_list  =  implode(', ', $enrollCourse->course->instructor_name);
            return $enrollCourse;
        });
        return response()->json([
            'data' => $myCourses
        ], 200);
    }
    private function _getYouTubeVideoId($url) {
        preg_match('/(?:youtube\.com\/(?:[^\/]+\/[^\/]+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/|youtube\.com\/embed\/)([^"&?\/\s]{11})/', $url, $matches);
        return $matches[1] ?? null;
    }
    private function _formatYouTubeDuration($duration)
    {
        preg_match('/PT(\d+H)?(\d+M)?(\d+S)?/', $duration, $matches);

        $hours = isset($matches[1]) ? (int) filter_var($matches[1], FILTER_SANITIZE_NUMBER_INT) : 0;
        $minutes = isset($matches[2]) ? (int) filter_var($matches[2], FILTER_SANITIZE_NUMBER_INT) : 0;
        $seconds = isset($matches[3]) ? (int) filter_var($matches[3], FILTER_SANITIZE_NUMBER_INT) : 0;

        if ($hours > 0) {
            return sprintf("%d:%02d:%02d", $hours, $minutes, $seconds); // Format as H:MM:SS
        } else {
            return sprintf("%d:%02d", $minutes, $seconds); // Format as MM:SS
        }
    }

    // myCourseDetail
    public function myCourseDetail($id)
    {
        $view_index = auth()->user()->course_view_index;
        $course = Course::with('type','videos','enrollCourses')->where('id',$id)->first();
        if($course){
            // instructor_name
            $course->instructor_name_list  =  implode(', ', $course->instructor_name);
            // count enrolled courses
            $course->enrolled = count($course->enrollCourses);
            // add base url to thumbnail
            $course->image = url('/'.$course->thumbnail);
            // duration_minutes to duration_hours
            $course->duration_hours = round(($course->duration_minutes / 60),1); 
            // Initialize YouTube Controller using Laravel's app() helper
            $youtube = app(APIYoutubeController::class);
            // Process course videos
            $course->videos = $course->videos->map(function ($video) use ($youtube) {
                // Extract YouTube video ID
                $videoId = $this->_getYouTubeVideoId($video->video_url);
                // Fetch YouTube video details
                $video->youtube_details = $youtube->videoDetail($videoId);
                $video->duration = $this->_formatYouTubeDuration($video->youtube_details['video']['contentDetails']['duration']);
                return $video;
            });
             // releated courses
            $releatedCourses = Course::with('videos','type')->where('status',1)->where('type_id',$course->type_id)->where('id','!=',$id)->limit(3)->get()->map(function($course){
                // add base url to thumbnail
                $course->image = url('/'.$course->thumbnail);
                // duration_minutes to duration_hours
                $course->duration_hours = round(($course->duration_minutes / 60),1); 
                return $course;
            });
            return response()->json(['status' => 200, 'course' => $course, 'releatedCourses' => $releatedCourses, 'view_index' => $view_index]);
        }else{
            return response()->json(['status' => 404, 'message' => 'Course not found']);
        }
    }
}
