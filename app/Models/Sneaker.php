<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sneaker extends Model
{
    use HasFactory;

    protected $fillable = [
        'runner_id',
        'model',
        'description',
        'max_kilometers',
        'current_kilometers',
    ];

    //Cada par de zapatillas (Sneaker) es usado por un solo Runner.
    public function runner()
    {
        return $this->belongsTo(Runner::class);
    }

}
