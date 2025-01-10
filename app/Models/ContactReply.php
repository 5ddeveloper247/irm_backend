<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactReply extends Model
{
    use HasFactory;
    // get Attachments
    public function attachments()
    {
        return $this->hasMany(ContactAttachment::class);
    }
}
