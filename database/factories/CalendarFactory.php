<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Calendar>
 */
class CalendarFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // La carrera tiene un 5% de probabilidad de ser importante
        $isImportant = $this->faker->boolean(5); 

        //Si es importante, el precio estará entre 40 y 150€, si no, entre 5 y 25
        $entryFee = $isImportant 
            ? $this->faker->numberBetween(40, 150) 
            : $this->faker->numberBetween(5, 25);

        //Calculo los premios según si la carrera es importante o no.
        //Pagando más en las carreras importantes

        $winnerReward = $entryFee * ($isImportant ? 6 : 4);
        $secondReward = $winnerReward * 0.5;
        $thirdReward = $winnerReward * 0.3;
        $topTenReward = $winnerReward * 0.1;

        //Las carreras serán viernes, sábados y domingos
        $currentYear = now()->year;
        $raceDate = $this->faker->dateTimeBetween("$currentYear-09-01", "$currentYear-12-31");
        $raceDate = Carbon::instance($raceDate);

        while (!in_array($raceDate->dayOfWeek, [Carbon::FRIDAY, Carbon::SATURDAY, Carbon::SUNDAY])) {
            $raceDate->addDay();
        }

        return [
            'race_name' => $this->faker->sentence(3),
            'race_date' => $raceDate->format('Y-m-d'),
            'entry_fee' => $entryFee,
            'distance' => $this->faker->randomFloat(3, 5, 42), // Distancia entre 1 y 42 km
            'difficulty' => $this->faker->numberBetween(1, 10),
            'is_important' => $isImportant,
            'weather' => null, //Determinaremos el clima según el mes
            'winner_reward' => $winnerReward,
            'second_reward' => $secondReward,
            'third_reward' => $thirdReward,
            'top_ten_reward' => $topTenReward,
        ];
 
    }

    public function withRaceDate($date)
    {
        return $this->state(function (array $attributes) use ($date) {
            return [
                'race_date' => $date,
                'weather' => $this->determineWeather($date),
            ];
        });
    }

    public function determineWeather($date)
    {
        $month = Carbon::parse($date)->month;

        if (in_array($month, [12, 1, 2])) {
            // Invierno: diciembre, enero, febrero
            return $this->faker->randomElement(['Lluvia', 'Frío', 'Viento']);
        } elseif (in_array($month, [6, 7, 8])) {
            // Verano: junio, julio, agosto
            return $this->faker->randomElement(['Calor', 'Calor extremo']);
        } else {
            // Otros meses (Primavera/Otoño)
            return $this->faker->randomElement(['Lluvia', 'Viento', 'Calor', 'Frío']);
        }
    }

}
