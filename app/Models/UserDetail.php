<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserDetail extends Model
{
    use HasFactory;
    // Fillable
    protected $fillable = [
        'user_id',
        'phoneNumber',
        'gender',
        'birthdate',
    ];
}
