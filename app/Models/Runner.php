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
        'profile_image',
        'speed',
        'endurance',
        'form',
        'mental',
        'tired',
        'nutrition_discipline',
        'rest_discipline',
        'vo2max',
        'injury_risk',
        'is_injury',
        'end_injury'
    ];

    /* 
      Un Runner pertenece a un User, tiene muchos Workouts, participa en muchas Races, y tiene una o más Sneakers
    */

    //Cada Runner pertenece a un único User.
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    //Un Runner tiene muchos Workouts.
    public function workouts()
    {
        return $this->hasMany(Workout::class);
    }

    //Un Runner puede tener varias zapatillas (Sneakers)
    public function sneakers()
    {
        return $this->hasMany(Sneaker::class);
    }

    //Un Runner puede participar en varias carreras (Races)
    public function races()
    {
        return $this->hasMany(Race::class);
    }

    public function getMediaAttribute()
    {
        $numericStats = [
            $this->speed,
            $this->endurance,
            $this->form,
            $this->mental,
            $this->vo2max,
        ];

        $categorialStats = [
            'A' => 100,
            'B' => 75,
            'C' => 50,
            'D' => 25,
        ];

        $categoryStats = [
            $categorialStats[$this->nutrition_discipline],
            $categorialStats[$this->rest_discipline],
            $categorialStats[$this->injury_risk],
        ];

        $allStats = array_merge($numericStats, $categoryStats);
        $average = array_sum($allStats) / count($allStats);

        return round($average, 2); // Devolvemos la media redondeada a dos decimales
    }

}
