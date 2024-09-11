@extends('dashboard/app')

@section('pageTitle', 'Carrera')

@section('content')
<div class="container mx-auto px-4">
    <h1 class="text-2xl font-bold mb-4">Progreso de la Carrera: {{ $calendar->race_name }}</h1>

    <div class="mb-4">
        <h2 class="text-xl font-semibold">Distancia total: {{ $calendar->distance }} km</h2>
        <h3 class="text-lg">Fecha de la carrera: {{ $calendar->race_date }}</h3>
        <h3 class="text-lg">Condiciones meteorológicas: {{ $calendar->weather }}</h3>
    </div>

    <div class="mb-6">
        <h2 class="text-xl font-bold">Progreso de los corredores:</h2>

        @foreach ($runners as $race)
            <div class="bg-gray-100 p-4 rounded shadow mb-4">
                <h3 class="text-lg font-semibold">{{ $race->runner->name }}</h3>

                @if ($race->progress_log)
                    @foreach (json_decode($race->progress_log, true) as $logEntry)
                        <p>Kilómetro {{ $logEntry['km'] }}:</p>
                        
                        <!-- Si es el primer corredor, no mostramos gap -->
                        @if ($logEntry['position'] == 1)
                            <p>Está en primera posición.</p>
                        @else
                            <!-- Para los demás corredores, mostramos el gap con el corredor anterior -->
                            <p>Está en la posición {{ $logEntry['position'] }}, a {{ $logEntry['time_gap'] }} segundos del corredor delante.</p>
                        @endif
                    @endforeach
                @else
                    <p>No hay actualizaciones disponibles aún.</p>
                @endif
            </div>
        @endforeach
    </div>

    <div>
        <h2 class="text-xl font-bold">Corredores inscritos:</h2>
        <ul class="list-disc pl-6">
            @foreach ($runners as $race)
                <li>{{ $race->runner->name }}</li>
            @endforeach
        </ul>
    </div>
</div>
@endsection