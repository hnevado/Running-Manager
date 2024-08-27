@extends('dashboard/app')

@section('pageTitle', 'Detalles corredor')

@section('content')
<div class="max-w-4xl mx-auto p-6 bg-white shadow-lg rounded-lg">
    <div class="flex flex-col md:flex-row items-center">
        <!-- Imagen de Perfil -->
        <div class="flex-shrink-0 mb-4 md:mb-0">
            <img class="w-32 h-32 rounded-full border-4 border-blue-500 object-cover" src="{{ $runner->profile_image }}" alt="Profile Image">
        </div>

        <!-- Información Básica -->
        <div class="md:ml-6 w-full">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <h2 class="text-xl font-bold text-gray-700">{{ $runner->name }}</h2>
                    <p class="text-sm text-gray-600">Edad: {{ $runner->age }} años</p>
                    <p class="text-sm text-gray-600">Peso: {{ $runner->weight }} kg</p>
                    <p class="text-sm text-gray-600">Altura: {{ $runner->height }} m</p>
                    <p class="text-sm text-gray-600">Nacionalidad: {{ $runner->nationality }}</p>
                </div>
                <div class="md:text-right">
                    <h3 class="text-2xl font-semibold text-gray-700">Precio</h3>
                    <p class="text-xl text-blue-500 font-bold {{ $runner->price > Auth::user()->balance ? 'text-red-500' : 'text-green-500' }}">{{ number_format($runner->price, 0, ',', '.') }} €</p>
                </div>
            </div>

            <!-- Stats Dinámicos -->
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <h4 class="font-semibold text-gray-700">Velocidad</h4>
                    <div class="w-full bg-gray-200 rounded-full h-4">
                        <div title="{{ $runner->speed }}%" class="bg-blue-500 h-4 rounded-l-full" style="width: {{ $runner->speed }}%;"></div>
                    </div>
                </div>
                <div>
                    <h4 class="font-semibold text-gray-700">Resistencia</h4>
                    <div class="w-full bg-gray-200 rounded-full h-4">
                        <div title="{{ $runner->endurance }}%" class="bg-green-500 h-4 rounded-l-full" style="width: {{ $runner->endurance }}%;"></div>
                    </div>
                </div>
                <div>
                    <h4 class="font-semibold text-gray-700">Estado de forma</h4>
                    <div class="w-full bg-gray-200 rounded-full h-4">
                        <div title="{{ $runner->form }}%" class="bg-yellow-500 h-4 rounded-l-full" style="width: {{ $runner->form }}%;"></div>
                    </div>
                </div>
                <div>
                    <h4 class="font-semibold text-gray-700">Mental</h4>
                    <div class="w-full bg-gray-200 rounded-full h-4">
                        <div title="{{ $runner->mental }}%" class="bg-red-500 h-4 rounded-l-full" style="width: {{ $runner->mental }}%;"></div>
                    </div>
                </div>
                <div>
                    <h4 class="font-semibold text-gray-700">VO2 Max</h4>
                    <div class="w-full bg-gray-200 rounded-full h-4">
                        <div title="{{ $runner->vo2max }}" class="bg-purple-500 h-4 rounded-l-full" style="width: {{ $runner->vo2max }}%;"></div>
                    </div>
                </div>
            </div>

            <!-- Stats "casi fijos" -->
            <div class="grid grid-cols-2 gap-4 mt-4">
                <div>
                    <h4 class="font-semibold text-gray-700">Disciplina Nutricional</h4>
                    <span class="inline-block px-3 py-1 text-sm font-semibold text-white bg-{{ $runner->nutrition_discipline == 'A' ? 'green' : ($runner->nutrition_discipline == 'B' ? 'yellow' : 'red') }}-500 rounded">
                        {{ $runner->nutrition_discipline }}
                    </span>
                </div>
                <div>
                    <h4 class="font-semibold text-gray-700">Disciplina de Descanso</h4>
                    <span class="inline-block px-3 py-1 text-sm font-semibold text-white bg-{{ $runner->rest_discipline == 'A' ? 'green' : ($runner->rest_discipline == 'B' ? 'yellow' : 'red') }}-500 rounded">
                        {{ $runner->rest_discipline }}
                    </span>
                </div>
                <div>
                    <h4 class="font-semibold text-gray-700">Riesgo de Lesiones</h4>
                    <span class="inline-block px-3 py-1 text-sm font-semibold text-white bg-{{ $runner->injury_risk == 'A' ? 'green' : ($runner->injury_risk == 'B' ? 'yellow' : 'red') }}-500 rounded">
                        {{ $runner->injury_risk }}
                    </span>
                </div>
            </div>

            @if (is_null($runner->user))
            <div class="mt-8">
              <form name="contratacion_runner" method="POST" action="{{route('storeRunner',$runner)}}">
                    @csrf
                    @method('PUT')
                    <x-primary-button class="bg-black-500">
                         {{ __('Contratar') }}
                    </x-primary-button>
                </form>
            </div>
            @endif 

            @if(session('success'))
                <div class="mt-4 bg-green-500 text-white p-2 rounded">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="mt-4 bg-red-500 text-white p-2 rounded">
                    {{ session('error') }}
                </div>
            @endif

        </div>
    </div>
</div>

@endsection