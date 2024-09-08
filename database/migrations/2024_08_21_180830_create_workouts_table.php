<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */

    /*
    Ejecutar cron en servidor 
    * * * * * cd /path-to-your-project && php artisan schedule:run >> /dev/null 2>&1
    
    php artisan update:runner-stats (sólo para actualizar los stats de los runners después de un entrenamiento)
    php artisan schedule:run ejecutar todos
    */
    public function up(): void
    {
        Schema::create('workouts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('runner_id');
            $table->foreign('runner_id')->references('id')->on('runners')->onUpdate('cascade')->onDelete('cascade');
            $table->enum('type', ['Rodaje', 'Series cortas', 'Series largas', 'Sesión de fuerza', 'Ejercicios de fortalecimiento y core'])->default('Rodaje');
            $table->integer('distance')->nullable(); // Distancia en kilómetros
            $table->integer('intensity'); // 1-10 para reflejar la dureza del entrenamiento
            $table->dateTime('end_workout')->nullable(); //A qué hora termina el entrenamiento
            $table->text('log')->nullable(); // Log del entrenamiento
            $table->boolean('processed')->default(false);
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
