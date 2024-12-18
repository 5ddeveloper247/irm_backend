<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    use HasFactory;

    public function type()
    {
        return $this->belongsTo(GalleryType::class, 'type_id');
    }

    public function attachments()
    {
        return $this->hasMany(GalleryAttachment::class,'gallery_id');
    }
}
