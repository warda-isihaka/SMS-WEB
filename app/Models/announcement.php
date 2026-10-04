<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class announcement extends Model
{
    protected $fillable = ['event_id', 'title', 'content', 'date'];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
    use HasFactory;

}

 