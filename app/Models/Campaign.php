<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Campaign extends Model
{
    use HasFactory;

    public function tasks()
    {
        return $this->hasMany(CampaignTask::class,'campaign_id');
    }
    // get comapaign total amount in payments table
    public function totalAmount()
    {
        return $this->hasMany('App\Models\Payment','campaign_id')->sum('amount');
    }
}
