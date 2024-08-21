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
        Schema::create('runners', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->timestamps();
            $table->string('name');
            $table->integer('age'); //Cada año +1
            $table->decimal('weight', 3, 1); // 3 dígitos en total, 1 para decimal. Ejemplo 75.2
            $table->decimal('height', 3, 2); //Ejemplo: 1.50 
            $table->string('category')->default('Amateur'); // Amateur, Profesional, Elite, etc.
            $table->string('sex')->default('man'); // Man, Woman
            $table->string('nationality')->default('Spain'); 

            // Stats dinámicos
            $table->integer('speed')->default(50); // Velocidad: 0-100
            $table->integer('endurance')->default(50); // Resistencia: 0-100
            $table->integer('form')->default(50); // Estado de forma: 0-100
            $table->integer('mental')->default(50); // Estado mental: 0-100
            $table->integer('tired')->default(0); // Nivel cansancio: 0-100

            //La disciplina de rendimiento y nutrición afectará al rendimiento
            $table->enum('nutrition_discipline', ['A', 'B', 'C', 'D'])->default('B'); // Disciplina nutricional
            $table->enum('rest_discipline', ['A', 'B', 'C', 'D'])->default('B'); // Disciplina de descanso

            // Stats "fijos" (estos pueden variar...pero muy poco en comparación a los dinámicos)
            $table->integer('vo2max')->default(50); // Capacidad aeróbica: 30 - 85 hombres / 30-70 mujeres
            $table->enum('injury_risk', ['A', 'B', 'C', 'D'])->default('B'); // Riesgo de lesión. Si haces muchas sesiones de fortalecimiento, core y prevención, puede cambiar.
            
            

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('runners');
    }
};
