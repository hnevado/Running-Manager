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
            $table->decimal('distance', 5, 2); // Distancia en kilómetros
            $table->integer('difficulty'); // Dificultad 1-10
            $table->enum('weather', ['Lluvia', 'Calor', 'Calor extremo','Frío', 'Viento'])->nullable(); // El tiempo que hará en la carrera
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
