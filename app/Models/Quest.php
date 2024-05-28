<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Category;
use App\Models\Campaign;

class Quest extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'points',
        'status',
        'category_id',
        'campaign_id',
        'repeatable',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function campaign()
    {
        return $this->belongsTo(Campaign::class);
    }

    public function questLogs()
    {
        return $this->hasMany(QuestLog::class);
    }

    // Add any additional methods specific to quests here (e.g., marking a quest as completed)
}
