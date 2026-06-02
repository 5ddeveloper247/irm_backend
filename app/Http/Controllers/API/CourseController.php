<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Services\CourseService;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function __construct(private CourseService $courseService)
    {
    }

    public function getCourses(Request $request)
    {
        $homepageCourse = $this->courseService->findHomepageCourse();

        $courses = Course::with(['type', 'enrollCourses'])
            ->where('status', 1)
            ->orderByDesc('id')
            ->get()
            ->map(fn ($course) => $this->courseService->formatCourseForApi($course));

        return response()->json([
            'status' => 200,
            'message' => '',
            'section_title' => $this->courseService->getSectionTitle($homepageCourse),
            'homepage_course' => $homepageCourse
                ? $this->courseService->formatCourseForApi($homepageCourse)
                : null,
            'courses' => $courses,
        ]);
    }

    public function getLastestCourses(Request $request)
    {
        $homepageCourse = $this->courseService->findHomepageCourse();

        $query = Course::with(['type', 'enrollCourses'])
            ->where('status', 1)
            ->orderByDesc('id');

        if ($homepageCourse) {
            $query->where('id', '!=', $homepageCourse->id);
        }

        $latestCourses = $query->limit(3)->get()
            ->map(fn ($course) => $this->courseService->formatCourseForApi($course));

        return response()->json([
            'status' => 200,
            'message' => '',
            'section_title' => $this->courseService->getSectionTitle($homepageCourse),
            'homepage_course' => $homepageCourse
                ? $this->courseService->formatCourseForApi($homepageCourse)
                : null,
            'courses' => $latestCourses,
        ]);
    }

    public function getSpecificCourse(Request $request, $id)
    {
        $course = Course::with(['type', 'enrollCourses', 'videos'])
            ->where('id', $id)
            ->where('status', 1)
            ->first();

        if (!$course) {
            return response()->json(['status' => 404, 'message' => 'Course not found']);
        }

        $formatted = $this->courseService->formatCourseForApi($course);
        $formatted['videos'] = $course->videos;

        $relatedCourses = Course::with(['type', 'enrollCourses'])
            ->where('status', 1)
            ->where('type_id', $course->type_id)
            ->where('id', '!=', $id)
            ->orderByDesc('id')
            ->limit(3)
            ->get()
            ->map(fn ($related) => $this->courseService->formatCourseForApi($related));

        return response()->json([
            'status' => 200,
            'message' => '',
            'section_title' => $this->courseService->getSectionTitle(
                $course->course_homepage ? $course : $this->courseService->findHomepageCourse()
            ),
            'course' => $formatted,
            'releatedCourses' => $relatedCourses,
        ]);
    }
}
