<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Campaign extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'tags',
        'welfare_section',
        'display_order',
        'description',
        'thumbnail',
        'target_amount',
        'date',
        'status',
    ];

    protected $appends = ['all_task_amount'];

    public function tasks()
    {
        return $this->hasMany(CampaignTask::class, 'campaign_id');
    }

    public function totalAmount()
    {
        return $this->hasMany('App\Models\Payment', 'compaign_id')->sum('amount');
    }

    public function getAllTaskAmountAttribute()
    {
        if (!$this->relationLoaded('tasks')) {
            $this->load('tasks');
        }

        return $this->tasks->pluck('task_amount')->implode(', ');
    }
}
