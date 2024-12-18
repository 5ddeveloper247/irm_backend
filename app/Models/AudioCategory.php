<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AudioCategory extends Model
{
    use HasFactory;

    public function audio_lectures()
    {
        return $this->hasMany(AudioLecture::class,'category_id');
    }
}
