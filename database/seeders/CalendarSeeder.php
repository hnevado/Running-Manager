<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use App\Models\Calendar;

class CalendarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $currentYear = now()->year;
        $dates = [];

        // Generar todas las fechas de viernes, sábados y domingos del año actual
        $startOfYear = Carbon::createFromDate($currentYear, 1, 1)->startOfYear();
        $endOfYear = Carbon::createFromDate($currentYear, 12, 31)->endOfYear();

        while ($startOfYear->lessThanOrEqualTo($endOfYear)) {
            if (in_array($startOfYear->dayOfWeek, [Carbon::FRIDAY, Carbon::SATURDAY, Carbon::SUNDAY])) {
                $dates[] = $startOfYear->format('Y-m-d');
            }
            $startOfYear->addDay();
        }

        // Mezclar las fechas para que la asignación sea aleatoria
        shuffle($dates);

        // Crear una carrera para cada fecha disponible
        foreach ($dates as $date) {
            Calendar::factory()->withRaceDate($date)->create();
        }
    }
}
