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
        $currentPositions = [];
        $timeGaps = [];

        // Inicializamos las posiciones de los corredores de manera aleatoria
        $currentPositions = $runners->pluck('runner.id')->shuffle()->values()->toArray();
        $timeGaps = array_fill_keys($currentPositions, 0); // Inicializamos los tiempos de gap en 0 para todos

        // Simulación por kilómetro
        for ($km = 1; $km <= $totalDistance; $km++) {
            echo "Kilómetro $km: \n";

            // Variables para almacenar la nueva posición y tiempos
            $newPositions = $currentPositions;  // Partimos de las posiciones actuales
            $leaderTime = 0;
            //$leaderId = null;

            foreach ($runners as $index => $race) {
                $runner = $race->runner;

                //Asignamos el tiempo de progreso con base en el clima y dificultad
                //Por defecto en recorrer un kilómetro tarda entre 3 minutos y 3 minutos 30 por kilómetro
                //A este tiempo se le suma, la dificultad de la carrera y las condiciones meteorológicas

                $timeProgress = rand(180, 210) / ($difficulty * 0.5);

                if ($weather === 'Lluvia' || $weather === 'Calor extremo') {
                    $timeProgress *= 1.5; // Penalización por mal clima
                }

                // Si es el primer corredor, es el líder
                if ($index === 0) {
                    $leaderTime = $timeProgress;
                    //$leaderId = $runner->id;
                    $newPositions[$index] = $runner->id; // El líder mantiene la posición
                    $timeGaps[$runner->id] = 0; // El líder no tiene nadie delante
                } else {
                    // Asignar nuevo tiempo al corredor basado en el líder
                    $previousRunnerId = $currentPositions[$index - 1]; // Corredor anterior
                    //$previousGap = $timeGaps[$previousRunnerId] ?? 0;

                    $timeGap = $leaderTime + rand(1, 5) / 10; // Incremento gradual
                    $timeGaps[$runner->id] = $timeGap;

                    // Decidir si el corredor adelanta o mantiene su posición
                    if (rand(0, 1) === 1 && $index > 1) { // Aleatoriamente permitimos adelantar
                        // Intercambiar posiciones con el corredor anterior
                        $newPositions[$index] = $newPositions[$index - 1];
                        $newPositions[$index - 1] = $runner->id;
                    } else {
                        // Mantiene su posición
                        $newPositions[$index] = $runner->id;
                    }
                }
            }

            // Actualizamos las posiciones y tiempos de cada corredor
            foreach ($runners as $index => $race) {
                $runner = $race->runner;
                $newPosition = array_search($runner->id, $newPositions) + 1; // Obtener la nueva posición
                $timeGap = $timeGaps[$runner->id];

                $progress = [
                    'km' => $km,
                    'position' => $newPosition,
                    'time_gap' => $timeGap,
                ];

                // Actualizamos el log de progreso
                $currentLog = json_decode($race->progress_log, true) ?? [];
                $currentLog[] = $progress;
                $race->progress_log = json_encode($currentLog);
                $race->save();

                // Mostrar el progreso del corredor
                if ($newPosition === 1) {
                    echo "El corredor {$runner->name} está en primera posición en el kilómetro $km.\n";
                } else {
                    // Mostrar gap con el corredor anterior
                    $previousRunnerId = $newPositions[$newPosition - 2] ?? null;
                    if ($previousRunnerId) {
                        $timeGapWithLeader = $timeGaps[$previousRunnerId] ?? 0;
                        echo "El corredor {$runner->name} está en la posición $newPosition en el kilómetro $km, a {$timeGapWithLeader} segundos del corredor delante.\n";
                    }
                }
            }

            // Actualizamos las posiciones actuales para el próximo kilómetro
            $currentPositions = $newPositions;
        }

        echo "La carrera ha finalizado.\n";
   }

}
