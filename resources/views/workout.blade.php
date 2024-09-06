@extends('dashboard/app')

@section('pageTitle', 'Asignar Entrenamiento')

@section('content')
<div class="container mx-auto px-4">
    <h1 class="text-2xl font-bold mb-4">Asignar Entrenamiento a un Corredor</h1>

    <!-- Mostrar si hay un entrenamiento activo -->
    @if($activeWorkout)
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4" role="alert">
            <strong>Atención:</strong> Hay un entrenamiento en curso para el corredor {{ $activeWorkout->runner->name }}. 
            El entrenamiento finaliza el {{ \Carbon\Carbon::parse($activeWorkout->end_workout)->format('d/m/Y H:i') }}.
        </div>
    @else
        <form method="POST" action="{{ route('assignWorkout') }}" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
            @csrf
            <div class="mb-4">
                <label for="runner_id" class="block text-gray-700 text-sm font-bold mb-2">Selecciona un corredor:</label>
                <select name="runner_id" id="runner_id" class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                    @foreach ($runners as $runner)
                        <option value="{{ $runner->id }}">{{ $runner->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label for="type" class="block text-gray-700 text-sm font-bold mb-2">Tipo de entrenamiento:</label>
                <select name="type" id="type" class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                    <option value="Rodaje">Rodaje</option>
                    <option value="Series cortas">Series cortas</option>
                    <option value="Series largas">Series largas</option>
                    <option value="Sesión de fuerza">Sesión de fuerza</option>
                    <option value="Ejercicios de fortalecimiento y core">Ejercicios de fortalecimiento y core</option>
                </select>
            </div>

            <div class="mb-4">
                <label for="intensity" class="block text-gray-700 text-sm font-bold mb-2">Distancia:</label>
                <input type="number" name="distance" id="distance" min="1" max="100" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
            </div>

            <div class="mb-4">
                <label for="intensity" class="block text-gray-700 text-sm font-bold mb-2">Intensidad (1-10):</label>
                <input type="number" name="intensity" id="intensity" min="1" max="10" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
            </div>

            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                Asignar Entrenamiento
            </button>
        </form>
    @endif

    <!-- Mostrar los logs de los entrenamientos anteriores -->
    <div class="mt-6">
        <h2 class="text-xl font-bold mb-4">Historial de Entrenamientos</h2>
        <ul class="space-y-4">
            @foreach($previousWorkouts as $workout)
                <li class="bg-gray-100 p-4 rounded shadow">
                    <strong>{{ $workout->runner->name }}</strong> - {{ $workout->type }} 
                    (Intensidad: {{ $workout->intensity }}) - {{ \Carbon\Carbon::parse($workout->end_workout)->format('d/m/Y H:i') }}
                    <p>{{ $workout->log }}</p>
                </li>
            @endforeach
        </ul>
    </div>
</div>
@endsection