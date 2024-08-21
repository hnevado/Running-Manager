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
        Schema::create('workouts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('runner_id');
            $table->foreign('runner_id')->references('id')->on('runners')->onUpdate('cascade')->onDelete('cascade');
            $table->enum('type', ['Rodaje', 'Series cortas', 'Series largas', 'Sesión de fuerza', 'Sesión de core', 'Estiramientos'])->default('Rodaje');
            $table->integer('duration')->nullable(); // Duración en minutos
            $table->integer('distance')->nullable(); // Distancia en kilómetros
            $table->integer('number_series')->nullable();
            $table->integer('intensity'); // 1-10 para reflejar la dureza del entrenamiento

            // Efecto en stats
            $table->integer('effect_on_speed')->default(0);
            $table->integer('effect_on_endurance')->default(0);
            $table->integer('effect_on_form')->default(0);
            $table->integer('effect_on_mental')->default(0);
            $table->integer('effect_on_tired')->default(0);
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('workouts');
    }
};
