<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    public function type()
    {
        return $this->belongsTo(CourseType::class, 'type_id');
    }

    public function videos()
    {
        return $this->hasMany(CourseVideo::class,'course_id');
    }
    // enroll courses
    public function enrollCourses()
    {
        return $this->hasMany(EnrollCourse::class,'course_id');
    }
}
