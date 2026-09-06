<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Budget extends Model
{
    use HasFactory;

    protected $table = 'budgets';
    protected $primaryKey = 'budget_id'; // Kulingana na SDD
    
    protected $fillable = [
        'user_id',
        'amount',
    ];
}