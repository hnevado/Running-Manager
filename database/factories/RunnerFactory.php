<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Runner;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Runner>
 */
class RunnerFactory extends Factory
{
    protected $model = Runner::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Genero los valores para los stats

        $runner = new Runner([
            'speed' => $this->faker->numberBetween(0, 100),
            'endurance' => $this->faker->numberBetween(0, 100),
            'form' => $this->faker->numberBetween(0, 100),
            'mental' => $this->faker->numberBetween(0, 100),
            'tired' => 0,
            'nutrition_discipline' => $this->faker->randomElement(['A', 'B', 'C', 'D']),
            'rest_discipline' => $this->faker->randomElement(['A', 'B', 'C', 'D']),
            'vo2max' => $this->faker->numberBetween(30, 85),
            'injury_risk' => $this->faker->randomElement(['A', 'B', 'C', 'D']),
        ]);

        $media = $runner->media;

        // Calculo el precio del runner basado en la media, con más probabilidad de valores bajos
        // aseguro que el precio de un Runner sea proporcional a su habilidad
        $basePrice = 300 + (9700 * pow($media / 100, 2));

        // Aplicar un redondeo al precio
        $price = round($basePrice);

        // Genero un nombre adecuado según el género
        $sex = $this->faker->randomElement(['man', 'woman']);
        $name = $sex === 'man' ? $this->faker->firstNameMale : $this->faker->firstNameFemale;

        return [
            'user_id' => null, // No asignado a ningún usuario por defecto
            'name' => $name,
            'age' => $this->faker->numberBetween(18, 45), 
            'weight' => $this->faker->randomFloat(1, 50, 100), 
            'height' => $this->faker->randomFloat(2, 1.50, 2.00), 
            'category' => $this->faker->randomElement(['Amateur', 'Profesional', 'Elite']),
            'sex' => $sex,
            'nationality' => $this->faker->country, 
            'profile_image' => $this->faker->imageUrl(640, 480, 'people', true, 'Runner'), 

            // Stats dinámicos
            'speed' => $runner->speed,
            'endurance' => $runner->endurance,
            'form' => $runner->form,
            'mental' => $runner->mental,
            'tired' => $runner->tired,

            // Disciplina nutricional y de descanso
            'nutrition_discipline' => $runner->nutrition_discipline,
            'rest_discipline' => $runner->rest_discipline,

            // Stats fijos
            'vo2max' => $runner->vo2max,
            'injury_risk' => $runner->injury_risk,

            // Precio calculado
            'price' => $price,
        ];
    }
}
