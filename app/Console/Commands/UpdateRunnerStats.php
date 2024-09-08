<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Workout;
use Carbon\Carbon;

class UpdateRunnerStats extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-runner-stats';
    
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Actualizar el cansancio y riesgo de lesión de los corredores después de un entrenamiento';

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Buscar entrenamientos que hayan terminado pero no hayan sido procesados aún
        $finishedWorkouts = Workout::where('end_workout', '<', Carbon::now())
            ->where('processed',0) // Campo para marcar si el entrenamiento ya fue procesado
            ->with('runner')
            ->get();

        foreach ($finishedWorkouts as $workout) {
            $runner = $workout->runner;

            // Calcular fatiga
            $fatigue = $workout->calculateFatigue();

            $runner->tired += $fatigue;
            
            if ($runner->tired > 100)
             $runner->tired = 100;

            // Calcular riesgo de lesión.
            //Compara el riesgo de lesión ($injuryRisk) con un número aleatorio.
            // Si el riesgo calculado es mayor que el número aleatorio, el corredor sufre una lesión.

            $injuryRisk = $workout->calculateInjuryRisk();
            $workout->log=$injuryRisk;
            if ($injuryRisk > random_int(0, 100)) {
                $runner->is_injury = 1;
                $runner->end_injury = Carbon::now()->addDays(random_int(1, 30)); // Simulamos un período de recuperación
                $workout->log = $workout->log.". Lamentablemente, tu runner se ha lesionado después de este entrenamiento. Lesionado hasta el ".$runner->end_injury;
            }

            // Guardar el estado del corredor
            $runner->save();

            // Marcar el entrenamiento como procesado
            $workout->processed = 1;
            $workout->save();
        }

        $this->info('Entrenamientos procesados y estadísticas de los corredores actualizadas.');
    }
}
