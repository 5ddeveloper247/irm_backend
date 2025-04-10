<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EnrollCourse extends Model
{
    use HasFactory;
    // course
    public function course()
    {
        return $this->belongsTo(Course::class);
    }
    // user
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
