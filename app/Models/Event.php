<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = ['user_id', 'title', 'description', 'event_date'];

    public function announcements()
    {
        return $this->hasMany(Announcement::class);
    }

    public function pledges()
    {
        return $this->hasMany(Pledge::class);
    }

    public function budgets()
    {
        return $this->hasMany(Budget::class);
    }

    use HasFactory;
}
