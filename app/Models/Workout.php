<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Workout extends Model
{
    use HasFactory;


    protected $fillable = [
        'runner_id',
        'type',
        'distance',
        'intensity',
        'end_workout',
        'log',
        'processed'
    ];

    // Método para calcular el aumento de cansancio basado en la intensidad
    public function calculateFatigue()
    {
        // Aumentamos el cansancio entre 5 y 10% por nivel de intensidad
        $baseFatigue = $this->intensity * (5 + ($this->intensity / 2));
        $runnerForm = $this->runner->form;

        // Ajuste según el estado de forma del corredor
        if ($runnerForm > 80) {
            return $baseFatigue * 0.25; //Corredores en una gran forma se fatigan muy poco
        }
        else if ($runnerForm > 50) {
            return $baseFatigue * 0.8; // Corredores en buena forma se fatigan menos
        } else {
            return $baseFatigue * 1.2; // Corredores en mala forma se fatigan más
        }
    }

    // Método para calcular el riesgo de lesión
    public function calculateInjuryRisk()
    {
        $injuryRisk = $this->runner->injury_risk; // Valor de A (mejor) a D (peor)
        $tiredness = $this->runner->tired; // Nivel de cansancio actual
        $shoeCondition = $this->runner->sneakers()->avg('current_kilometers') / $this->runner->sneakers()->avg('max_kilometers'); // Proporción de desgaste

        // Fórmula simple que tiene en cuenta todos los factores

        /* 
        $this->intensity * ($tiredness / 100): Aquí, el nivel de intensidad del entrenamiento multiplica el nivel de 
        cansancio actual del corredor (expresado en porcentaje). A mayor intensidad y mayor cansancio, más alto será el riesgo de lesión.
        $shoeCondition * 30: Este factor multiplica el estado de las zapatillas por 30. Si las zapatillas están muy desgastadas 
        (más allá de su límite de kilómetros), su condición empeora, lo que incrementa el riesgo de lesión.
        */

        $baseRisk = $this->intensity * ($tiredness / 100) + $shoeCondition * 30;
        
        // Ajustamos según el riesgo de lesión del corredor
        switch ($injuryRisk) {
            case 'A':
                return $baseRisk * 0.5; // Menos propenso a lesiones
            case 'B':
                return $baseRisk * 0.75;
            case 'C':
                return $baseRisk * 1.0;
            case 'D':
                return $baseRisk * 1.5; // Más propenso a lesiones
        }

        return $baseRisk; 
    }

    public function runner()
    {
        return $this->belongsTo(Runner::class);
    }
}
