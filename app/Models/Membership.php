<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Membership extends Model
{
    use HasFactory;

    protected $fillable = [
        'username',
        'email',
        'phone',
        'country_id',
        'city',
    ];

    public function country()
    {
        return $this->belongsTo(Country::class);
    }
}