<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Workout extends Model
{
    use HasFactory;


    protected $fillable = [
        'runner_id',
        'type',
        'duration',
        'distance',
        'number_series',
        'number_series',
        'intensity',
        'effect_on_speed',
        'effect_on_endurance',
        'effect_on_form',
        'effect_on_mental',
        'effect_on_tired'

    ];

    public function runner()
    {
        return $this->belongsTo(Runner::class);
    }
}
