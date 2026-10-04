<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;


class Pledge extends Model
{
    use HasFactory;

    protected $primaryKey = 'pledge_id';

    protected $fillable = [
        'user_id',
        'category',
        'amount',
        'paid',
        'remain',
        'payment_method',
        'status',
        'is_scanned',
        'qr_code',
        'event_id', 'title', 'content', 'date'
    ];
    protected static function booted()
    {
        static::creating(function ($pledge) {
            $pledge->qr_code = 'SMS-' .strtoupper(Str::random(8));
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    }



