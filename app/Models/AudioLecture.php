<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AudioLecture extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'title',
        'speaker',
        'description',
        'thumbnail',
        'date',
        'status',
        'duration',
        'audio_source_type',
        'embed_url',
        'external_url',
    ];

    public function category()
    {
        return $this->belongsTo(AudioCategory::class, 'category_id');
    }

    public function attachments()
    {
        return $this->hasMany(AudioLectureAttachment::class, 'audio_id');
    }
}
