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
        Schema::create('sneakers', function (Blueprint $table) {
            $table->id();
            
            $table->unsignedBigInteger('runner_id');
            $table->foreign('runner_id')->references('id')->on('runners')->onUpdate('cascade')->onDelete('cascade');

            $table->string('model');
            $table->string('description');
            $table->integer('max_kilometers'); // Kilómetros máximos antes de degradarse
            $table->integer('current_kilometers')->default(0); // Kilómetros recorridos hasta ahora
            $table->integer('price')->default(0); // precio zapatilla
            $table->boolean('is_broken')->default(0); // ¿Están rotas las zapatillas?
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sneakers');
    }
};
