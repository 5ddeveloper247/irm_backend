<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NewsEvent extends Model
{
    use HasFactory;

    public function attachments()
    {
        return $this->hasMany(NewsEventAttachment::class,'news_id');
    }
}
