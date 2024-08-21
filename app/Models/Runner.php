<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Runner extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'age',
        'weight',
        'height',
        'category',
        'speed',
        'endurance',
        'form',
        'mental',
        'tired',
        'nutrition_discipline',
        'rest_discipline',
        'vo2max',
        'injury_risk',
    ];

}
