<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\CourseType;
class CourseController extends Controller
{
    // get courses with courseType
    public function getCourses(Request $request)
    {

        // add status = 1 to get only active courses
        $courses = Course::with('type','enrollCourses')->where('status',1)->get()->map(function($course){
            // instructor_name to instructor_name_list
            $course->instructor_name_list  =  implode(', ', $course->instructor_name);
            // count enrolled courses
            $course->enrolled = count($course->enrollCourses);
            // add base url to thumbnail
            $course->image = url('/'.$course->thumbnail);
            // duration_minutes to duration_hours
            $course->duration_hours = round(($course->duration_minutes / 60),1);
            return $course;
        });
        return response()->json(['status' => 200, 'courses' => $courses]);
    }
    // getLastestCourses
    public function getLastestCourses(Request $request)
    {
        // add status = 1 to get only active courses
        $courses = Course::with('type','enrollCourses')->where('status',1)->orderBy('id','desc')->limit(3)->get()->map(function($course){
            // instructor_name to instructor_name_list
            $course->instructor_name_list  =  implode(', ', $course->instructor_name);
            // count enrolled courses
            $course->enrolled = count($course->enrollCourses);
             // duration_minutes to duration_hours
             $course->duration_hours = round(($course->duration_minutes / 60),1); 
            // add base url to thumbnail
            $course->image = url('/'.$course->thumbnail);
            return $course;
        });
        return response()->json(['status' => 200, 'courses' => $courses]);
    }
    // get single course
    public function getSpecificCourse(Request $request, $id)
    {
        $course = Course::with('type','enrollCourses')->where('id',$id)->first();
        if($course){
            // instructor_name to instructor_name_list
            $course->instructor_name_list  =  implode(', ', $course->instructor_name);
            // count enrolled courses
            $course->enrolled = count($course->enrollCourses);
            // add base url to thumbnail
            $course->image = url('/'.$course->thumbnail);
            // duration_minutes to duration_hours
            $course->duration_hours = round(($course->duration_minutes / 60),1); 
             // releated courses
            $releatedCourses = Course::with('videos','type')->where('status',1)->where('type_id',$course->type_id)->where('id','!=',$id)->limit(3)->get()->map(function($course){
                // instructor_name to instructor_name_list
                $course->instructor_name_list  =  implode(', ', $course->instructor_name);
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
