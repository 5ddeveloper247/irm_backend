<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;
    // get campaign total amount in payments table
    public function campaign()
    {
        return $this->belongsTo('App\Models\Campaign','campaign_id');
    }
    
}
