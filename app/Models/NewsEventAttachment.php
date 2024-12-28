<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NewsEventAttachment extends Model
{
    use HasFactory;

    public function event()
    {
        return $this->belongsTo(NewsEvent::class, 'news_id');
    }
}
