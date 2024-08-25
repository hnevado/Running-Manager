<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Calendar extends Model
{
    use HasFactory;

    protected $fillable = [
        'race_name',
        'race_date',
        'entry_fee',
        'distance',
        'difficulty',
        'is_important',
        'weather',
        'winner_reward',
        'second_reward',
        'third_reward',
        'top_ten_reward'
    ];

    /*
     Un evento de Calendar puede tener múltiples participaciones (Races). Es decir, 
     un evento del calendario puede incluir la participación de varios corredores.
     */

    public function races()
    {
        return $this->hasMany(Race::class);
    }

}
