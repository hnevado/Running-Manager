@extends('dashboard/app')

@section('pageTitle', 'Runner Detail')

@section('stats')
    <!-- aquí irán las estadísticas runner -->
@endsection

@section('content')
    <h1>Detalles del Runner</h1>
    <ul>
        @foreach($runner->getAttributes() as $key => $value)
            <li><strong>{{ ucfirst($key) }}:</strong> {{ $value }}</li>
        @endforeach
    </ul>
@endsection