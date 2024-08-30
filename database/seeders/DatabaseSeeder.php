<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Runner;
use App\Models\Sneaker;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        
        Runner::factory(100)->create();
        $this->call(CalendarSeeder::class);

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        Runner::orderBy('id', 'ASC')->each(function ($runner) {
            // Crear las zapatillas de entrenamiento
            Sneaker::factory()->training()->create([
                'runner_id' => $runner->id,
            ]);
        
            // Crear las zapatillas de competición
            Sneaker::factory()->competition()->create([
                'runner_id' => $runner->id,
            ]);
        });

    }
}
