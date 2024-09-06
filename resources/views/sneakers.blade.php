@extends('dashboard/app')

@section('pageTitle', 'Tienda Running')

@section('content')

<div class="container mx-auto">
    <h1 class="text-2xl font-bold mb-6">Tus Zapatillas</h1>
    
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach ($sneakers as $sneaker)
        <div class="bg-white shadow-md rounded-lg p-6">
            <h2 class="text-xl font-semibold text-gray-700">{{ $sneaker->runner->name }}</h2>
            <p class="text-gray-600">{{ $sneaker->description }}</p>
            <p class="text-gray-600">Modelo: {{ $sneaker->model }}</p>
            <p class="text-gray-600">Kilómetros actuales: {{ $sneaker->current_kilometers }} / {{ $sneaker->max_kilometers }} km</p>
            <p class="text-gray-600">Precio: {{ $sneaker->price }} €</p>
            <p class="text-gray-600">Estado: 
                @if($sneaker->is_broken)
                    <span class="text-red-500">Rotas</span>
                @else
                    <span class="text-green-500">En buen estado</span>
                @endif
            </p>

            <form method="POST" action="#">
                @csrf
                <button type="submit" class="mt-4 px-4 py-2 
                                            {{ ($sneaker->current_kilometers > $sneaker->max_kilometers) ? 'bg-red-500' : 'bg-blue-500' }} 

                                            text-white font-semibold rounded">
                    Renovar zapatilla
                </button>
            </form>
        </div>
        @endforeach
    </div>
</div>

@endsection