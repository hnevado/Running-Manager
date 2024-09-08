<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use App\Console\Commands\UpdateRunnerStats;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

Artisan::command('update:runner-stats', function () {
    $this->call(UpdateRunnerStats::class);
})->describe('Actualiza las estadísticas de los corredores');
