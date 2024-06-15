<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Badge extends Model
{
    use HasFactory;

    public function heroes()
    {
        return $this->belongsToMany(User::class, 'hero_badge');
    }

}
