<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AudioLectureAttachment extends Model
{
    use HasFactory;

    public function audio_lecture()
    {
        return $this->belongsTo(AudioLecture::class, 'audio_id');
    }
}
