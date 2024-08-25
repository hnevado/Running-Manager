<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('calendars', function (Blueprint $table) {
            $table->id();
            $table->string('race_name');
            $table->date('race_date');
            $table->integer('entry_fee'); // Precio de inscripción
            $table->decimal('distance', 5, 3); // Distancia en kilómetros
            $table->integer('difficulty'); // Dificultad 1-10
            $table->boolean('is_important')->default(0); //Si es una carrera importante, los premios serán mayores y habrá más participación
            $table->enum('weather', ['Lluvia', 'Calor', 'Calor extremo','Frío', 'Viento'])->nullable(); // El tiempo que hará en la carrera
            $table->integer('winner_reward'); // Premio al ganador y ganador
            $table->integer('second_reward'); // Premio al segundo y segunda clasificado/a
            $table->integer('third_reward'); // Premio al tercer y tercera clasificado/a
            $table->integer('top_ten_reward'); //Premio por entrar del 4º al 10º 
            $table->boolean('is_closed')->default(0); //Por defecto las inscripciones no están cerradas
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('calendars');
    }
};
