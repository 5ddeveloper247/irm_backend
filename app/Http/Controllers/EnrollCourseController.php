<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EnrollCourse;
use Illuminate\Support\Facades\Validator;
use App\Models\Course;
class EnrollCourseController extends Controller
{
    // enrollCourses
    public function enrollCourses(){
        return view('admin.enrollcourses');
    }
    // getAllEnrollCourse
    public function getEnrollCoursesPageData()
    {
        $data['enrollCourse_list'] = EnrollCourse::with('course')->orderBy('id','desc')->get();
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
            return $enrollCourse;
        });
        return response()->json([
            'data' => $myCourses
        ], 200);
    }
    // myCourseDetail
    public function myCourseDetail($id)
    {
        $course = Course::with('type','videos','enrollCourses')->where('id',$id)->first();
        if($course){
            // count enrolled courses
            $course->enrolled = count($course->enrollCourses);
            // add base url to thumbnail
            $course->image = url('/'.$course->thumbnail);
            // duration_minutes to duration_hours
            $course->duration_hours = round(($course->duration_minutes / 60),1); 
             // releated courses
            $releatedCourses = Course::with('videos','type')->where('status',1)->where('type_id',$course->type_id)->where('id','!=',$id)->limit(3)->get()->map(function($course){
                // add base url to thumbnail
                $course->image = url('/'.$course->thumbnail);
                // duration_minutes to duration_hours
                $course->duration_hours = round(($course->duration_minutes / 60),1); 
                return $course;
            });
            return response()->json(['status' => 200, 'course' => $course, 'releatedCourses' => $releatedCourses]);
        }else{
            return response()->json(['status' => 404, 'message' => 'Course not found']);
        }
    }
}
