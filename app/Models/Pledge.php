<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }



}