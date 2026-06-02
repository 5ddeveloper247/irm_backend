<?php

namespace App\Services;

use App\Models\Course;

class CourseService
{
    public function formatCourseForApi(Course $course): array
    {
        $course->loadMissing(['type', 'enrollCourses']);

        $instructors = $course->instructor_name;
        if (!is_array($instructors)) {
            $instructors = [];
        }

        $durationMinutes = (int) ($course->duration_minutes ?? 0);
        $durationHours = $durationMinutes > 0 ? round($durationMinutes / 60, 1) : 0;

        $sectionTitle = $course->homepage_section_title
            ?: 'Fehm-e-Deen Course';

        return [
            'id' => $course->id,
            'title' => $course->title,
            'section_title' => $sectionTitle,
            'description' => $course->description,
            'eligibility' => $course->eligibility,
            'instructor_name' => $instructors,
            'instructor_name_list' => implode(', ', $instructors),
            'duration_minutes' => $durationMinutes,
            'duration_hours' => $durationHours,
            'total_course_duration' => $course->total_course_duration,
            'duration_label' => $this->buildDurationLabel($durationMinutes, $course->total_course_duration),
            'total_lectures' => $course->total_lectures,
            'level' => $course->level,
            'language' => $course->language,
            'certificate' => $course->certificate,
            'date' => $course->date,
            'image' => $course->thumbnail ? url('/' . $course->thumbnail) : null,
            'thumbnail' => $course->thumbnail,
            'status' => (int) $course->status,
            'enrolled' => $course->enrollCourses->count(),
            'enroll_enabled' => (int) ($course->enroll_enabled ?? 1),
            'course_homepage' => (int) ($course->course_homepage ?? 0),
            'type_id' => $course->type_id,
            'type_name' => $course->type?->title,
            'created_at' => $course->created_at,
            'updated_at' => $course->updated_at,
        ];
    }

    public function findHomepageCourse(): ?Course
    {
        return Course::with(['type', 'enrollCourses'])
            ->where('status', 1)
            ->where('course_homepage', 1)
            ->orderByDesc('id')
            ->first();
    }

    public function getDefaultSectionTitle(): string
    {
        return 'Fehm-e-Deen Course';
    }

    public function getSectionTitle(?Course $homepageCourse = null): string
    {
        if ($homepageCourse && !empty($homepageCourse->homepage_section_title)) {
            return $homepageCourse->homepage_section_title;
        }

        return $this->getDefaultSectionTitle();
    }

    public function syncHomepageFlag(int $courseId, bool $isHomepage): void
    {
        if (!$isHomepage) {
            return;
        }

        Course::where('id', '!=', $courseId)->update(['course_homepage' => 0]);
    }

    private function buildDurationLabel(int $durationMinutes, ?string $totalDuration): string
    {
        $parts = [];

        if ($durationMinutes > 0) {
            $parts[] = $durationMinutes . ' min per class';
        }

        if (!empty($totalDuration)) {
            $parts[] = $totalDuration;
        }

        return implode(' · ', $parts);
    }
}
