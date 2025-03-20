<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Campaign extends Model
{
    use HasFactory;
    protected $appends = ['all_task_amount']; // Ensure attribute is included in JSON output

    public function tasks()
    {
        return $this->hasMany(CampaignTask::class, 'campaign_id');
    }
    // get comapaign total amount in payments table
    public function totalAmount()
    {
        return $this->hasMany('App\Models\Payment', 'campaign_id')->sum('amount');
    }
    // Accessor to get all task_amount values as a comma-separated string
    public function getAllTaskAmountAttribute()
    {
        if (!$this->relationLoaded('tasks')) {
            $this->load('tasks'); // Ensure tasks are loaded
        }
        return $this->tasks->pluck('task_amount')->implode(', ');
    }
}
