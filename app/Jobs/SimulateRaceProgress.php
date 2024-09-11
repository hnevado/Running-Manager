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
    // Obtener los corredores inscritos en la carrera
    $runners = Race::where('calendar_id', $calendar->id)->with('runner')->get();

    // Variables iniciales para la simulación
    $totalDistance = $calendar->distance; // Distancia total de la carrera
    $weather = $calendar->weather; // El tiempo/clima durante la carrera
    $difficulty = $calendar->difficulty; // Dificultad de la carrera
    $currentPositions = []; // Mantener un registro de las posiciones actuales de los corredores

    // Asignar posición inicial aleatoria a los corredores
    foreach ($runners as $race) {
        $currentPositions[$race->runner->id] = rand(1, count($runners)); // Posición inicial
    }

    // Simulación por kilómetro y guardar progreso
    for ($km = 1; $km <= $totalDistance; $km++) {
        echo "Kilómetro $km: \n";

        foreach ($runners as $race) {
            $runner = $race->runner;
            $currentPosition = $currentPositions[$runner->id];

            // Simulación del progreso del corredor basada en factores como clima y dificultad
            $timeGap = rand(1, 10) / ($difficulty * 0.5); // El tiempo entre corredores depende de la dificultad
            if ($weather === 'Lluvia' || $weather === 'Calor extremo') {
                $timeGap *= 1.5; // Condiciones climáticas adversas aumentan el tiempo entre corredores
            }

            // Actualización de la posición del corredor
            $newPosition = $currentPosition - rand(0, 2); // El corredor puede mantener o ganar posiciones
            $newPosition = max(1, min(count($runners), $newPosition)); // Asegurarse de que la posición sea válida

            // Actualizar la posición actual del corredor
            $currentPositions[$runner->id] = $newPosition;

            // Generar el log de progreso para este corredor
            $progress = [
                'km' => $km,
                'position' => $newPosition,
                'time_gap' => $timeGap,
            ];

            // Obtener el log actual y actualizarlo con el progreso
            $currentLog = json_decode($race->progress_log, true) ?? [];
            $currentLog[] = $progress;

            // Guardar el log actualizado en formato JSON
            $race->progress_log = json_encode($currentLog);
            $race->save();

            // Mostrar el progreso 
            echo "El corredor {$runner->name} está en la posición $newPosition en el kilómetro $km. \n";
        }

        // Simular un intervalo de tiempo entre cada kilómetro (esto puedes controlarlo con delays si deseas)
        sleep(5); // Simulación de que pasan 5 minutos entre cada kilómetro
    }

    // Final de la carrera: mostrar los resultados
    echo "La carrera ha finalizado. Resultados finales:\n";
    foreach ($runners as $race) {
        $runner = $race->runner;
        $finalPosition = $currentPositions[$runner->id];

        echo "Corredor: {$runner->name}, Posición final: $finalPosition \n";

        // Guardar el resultado final en la base de datos
        $race->result = $finalPosition;
        $race->time = now(); // Esto se puede cambiar por un tiempo realista
        $race->save();
    }
  }

}
