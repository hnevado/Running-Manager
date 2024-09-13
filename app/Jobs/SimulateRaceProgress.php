<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Race;
use App\Models\Calendar;

class SimulateRaceProgress implements ShouldQueue
{
    use Queueable;
    protected $calendar;

    /**
     * Create a new job instance.
     */
    public function __construct(Calendar $calendar)
    {
        $this->calendar = $calendar;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // Ejecuta la simulación de la carrera
        $this->simulateRaceProgress($this->calendar);
    }

    public function simulateRaceProgress(Calendar $calendar)
    {
        $runners = Race::where('calendar_id', $calendar->id)->with('runner')->get();

        $totalDistance = $calendar->distance;
        $weather = $calendar->weather;
        $difficulty = $calendar->difficulty;
        $currentPositions = $runners->pluck('runner.id')->shuffle()->values()->toArray();
        $timeGaps = array_fill_keys($currentPositions, 0); // Inicializamos los tiempos de gap en 0 para todos
        $totalTimes = array_fill_keys($currentPositions, 0); // Inicializamos el tiempo total de cada corredor

        // Simulación por kilómetro
        for ($km = 1; $km <= $totalDistance; $km++) {
            echo "Kilómetro $km: \n";

            // Variables para almacenar las posiciones y tiempos
            $newPositions = $currentPositions;
            $timesForThisKilometer = [];

            // Calcular el tiempo de progreso para cada corredor
            foreach ($runners as $index => $race) {
                $runner = $race->runner;


                // Calculamos la media de los stats del corredor
                $runnerStats = [
                    $runner->speed,
                    $runner->endurance,
                    $runner->form,
                    $runner->mental,
                    $runner->vo2max,
                ];
                $averageStats = array_sum($runnerStats) / count($runnerStats);


                // Asignamos el tiempo de progreso con base en el clima y dificultad
                //$timeProgress = rand(180, 220) / ($difficulty * 0.5);
                $timeProgress = 340 - (180 * ($averageStats / 100));
            
                // Penalización por fatiga
                if ($runner->tired > 85) {
                    $timeProgress += rand(5, 10); // Penalización de 5 a 10 segundos por fatiga alta
                } else if ($runner->tired > 50) {
                    $timeProgress += rand(3, 5); // Penalización de 3 a 5 segundos por fatiga media
                } else if ($runner->tired > 25) {
                    $timeProgress += rand(1, 3); // Penalización de 1 a 3 segundos por fatiga baja
                }

                //Penalización de tiempo por dificultad de carrera
                if ($difficulty > 8)
                  $timeProgress += $timeProgress += rand(5, 10);
                if ($difficulty > 5)
                  $timeProgress += $timeProgress += rand(1, 5);
                
                //Parte aleatoria de ritmo por kilómetro, si no sería todo muy lineal si solo lo calculamos en base a sus stats
                //y nunca variaría nada.

                $timeProgress = $timeProgress + rand(-5, 5); 
                echo "Ritmo por kilómetro de ".$runner->name." es de ".$timeProgress."\n";
                if ($weather === 'Lluvia' || $weather === 'Calor extremo') {
                    $timeProgress *= 1.5; // Penalización por mal clima
                }

                // Sumamos el tiempo de progreso acumulado
                $totalTimes[$runner->id] += $timeProgress;
                $timesForThisKilometer[$runner->id] = $totalTimes[$runner->id]; // Guardamos el tiempo para este kilómetro
            }

            // Ordenamos a los corredores según su tiempo acumulado (el más rápido va primero)
            asort($timesForThisKilometer);
            $sortedRunners = array_keys($timesForThisKilometer); // IDs de corredores ordenados por su tiempo acumulado

            // Actualizamos las posiciones y calculamos los gaps
            foreach ($sortedRunners as $position => $runnerId) {
                $runner = $runners->firstWhere('runner.id', $runnerId)->runner;

                // El líder es el primer corredor en la lista ordenada
                if ($position === 0) {
                    $timeGaps[$runnerId] = 0; // El líder no tiene nadie delante
                    echo "El corredor {$runner->name} está en primera posición en el kilómetro $km.\n";
                } else {
                    // El gap es la diferencia de tiempo acumulado con respecto al corredor delante
                    $previousRunnerId = $sortedRunners[$position - 1];
                    $timeGaps[$runnerId] = $totalTimes[$runnerId] - $totalTimes[$previousRunnerId];

                    echo "El corredor {$runner->name} está en la posición " . ($position + 1) . " en el kilómetro $km, a {$timeGaps[$runnerId]} segundos del corredor delante.\n";
                }

                // Actualizamos el log de progreso
                $progress = [
                    'km' => $km,
                    'position' => $position + 1,
                    'time_gap' => $timeGaps[$runnerId],
                ];

                $currentLog = json_decode($runners->firstWhere('runner.id', $runnerId)->progress_log, true) ?? [];
                $currentLog[] = $progress;
                $runners->firstWhere('runner.id', $runnerId)->progress_log = json_encode($currentLog);
                $runners->firstWhere('runner.id', $runnerId)->save();
            }

            // Actualizamos las posiciones actuales con el nuevo orden
            $currentPositions = $sortedRunners;
        }

        echo "La carrera ha finalizado.\n";
  }

}
