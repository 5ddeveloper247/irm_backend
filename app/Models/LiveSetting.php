<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LiveSetting extends Model
{
    protected $table = 'live_settings';

    protected $fillable = [
        'platform',
        'live_url',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'integer',
    ];
}