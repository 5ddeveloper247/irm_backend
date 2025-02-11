<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Course extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'description',
        'type_id',
        'instructor_name',
        'duration_minutes',
        'total_lectures',
        'level',
        'language',
        'certificate',
        'date',
        'thumbnail',
        'status',
        'course_eligibility',
    ];
     /**
     * Mutator & Accessor for `instructor_name`
     */
    protected function instructorName(): Attribute
    {
        return Attribute::make(
            set: function ($value) {
                // Ensure value is an array before processing
                if (!is_array($value)) {
                    return json_encode([]); // Return empty JSON if not an array
                }

                // Extract only 'name' values, remove empty/null values
                $names = collect($value)
                    ->pluck('name')    // Get only 'name' values
                    ->filter()         // Remove null or empty names
                    ->values()         // Reset array keys
                    ->all();           // Convert to a plain array

                return json_encode($names);  // Return names as JSON
            },
            get: fn ($value) => json_decode($value, true) ?? [] // Decode JSON back to array when getting value
        );
    }
    

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
