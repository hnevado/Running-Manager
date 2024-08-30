<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Sneaker>
 */
class SneakerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'runner_id' => null, // Esto se establecerá al crear las zapatillas
            'model' => $this->faker->word,
            'description' => '', // Este valor lo especificamos en la función training o competition
            'max_kilometers' => 0, // Este valor lo especificamos en la función training o competition
            'current_kilometers' => 0,
            'price' => 0, // Valor predeterminado
            'is_broken' => 0,
        ];
     }
    
    public function training()
    {
        return $this->state([
            'description' => 'Zapatillas de entrenamiento',
            'max_kilometers' => rand(800, 1200),
            'price' => rand(80, 150),
        ]);
    }

    public function competition()
    {
        return $this->state([
            'description' => 'Zapatillas de competición',
            'max_kilometers' => rand(300, 500),
            'price' => rand(180, 300),
        ]);
    }
}
