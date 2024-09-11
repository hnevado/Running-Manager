<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Race extends Model
{
    use HasFactory;

    protected $fillable = [
        'runner_id',
        'calendar_id',
        'result',
        'time',
        'progress_log'
    ];

    //Una Race representa la participación de un Runner en una carrera específica.
    public function runner()
    {
        return $this->belongsTo(Runner::class);
    }

    public function calendar()
    {
        return $this->belongsTo(Calendar::class);
    }
}
