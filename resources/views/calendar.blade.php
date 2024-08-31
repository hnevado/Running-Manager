@extends('dashboard/app')

@section('pageTitle', 'Calendario de Carreras')

@section('content')
<div class="flex flex-col mt-8">
    <div class="py-2 overflow-x-auto sm:px-6 lg:px-8">
        <div class="min-w-full align-middle border-b border-gray-200 shadow sm:rounded-lg">

          @if(session('success'))
             <div class="mb-4 bg-green-500 text-white p-2 rounded">
                 {{ session('success') }}
              </div>
           @endif

           @if(session('error'))
               <div class="mb-4 bg-red-500 text-white p-2 rounded">
                  {{ session('error') }}
               </div>
            @endif


            <table class="min-w-full">
                <thead>
                    <tr>
                        <th class="px-6 py-3 text-xs font-medium text-left text-gray-500 uppercase bg-gray-50">Fecha</th>
                        <th class="px-6 py-3 text-xs font-medium text-left text-gray-500 uppercase bg-gray-50">Carrera</th>
                        <th class="px-6 py-3 text-xs font-medium text-left text-gray-500 uppercase bg-gray-50">Coste</th>
                        <th class="px-6 py-3 text-xs font-medium text-left text-gray-500 uppercase bg-gray-50">Distancia</th>
                        <th class="px-6 py-3 text-xs font-medium text-left text-gray-500 uppercase bg-gray-50">Dureza</th>
                        <th class="px-6 py-3 text-xs font-medium text-left text-gray-500 uppercase bg-gray-50">Premios</th>
                        <th class="px-6 py-3 text-xs font-medium text-left text-gray-500 uppercase bg-gray-50">Inscripción</th>
                    </tr>
                </thead>
                <tbody class="bg-white">
                    @foreach ($calendar as $race)
                        <tr class="{{ $race->is_important ? 'bg-green-100' : 'bg-white' }} hover:bg-gray-100">
                            <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                                {{ \Carbon\Carbon::parse($race->race_date)->format('d/m') }}
                            </td>
                            <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                                {{$race->race_name}}
                            </td>
                            <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                                {{$race->entry_fee}} €
                            </td>
                            <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                                {{$race->distance}} km
                            </td>
                            <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                                {{$race->difficulty}}/10
                            </td>
                            <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                                1º: {{$race->winner_reward}} €<br>
                                2º: {{$race->second_reward}} €<br>
                                3º: {{$race->third_reward}} €<br>
                                4º-10º: {{$race->top_ten_reward}} €
                            </td>
                            <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">

                                <form method="POST" action="{{ route('runnerInscription', $race->id) }}">
                                    @csrf
                                    <label for="runner_id" class="sr-only">Selecciona un corredor</label>
                                    <select name="runner_id" id="runner_id" class="px-2 py-1 border rounded w-full">
                                        @foreach ($runners as $runner)
                                            <option value="{{ $runner->id }}">{{ $runner->name }}</option>
                                        @endforeach
                                    </select>
                                    <button type="submit" class="px-4 py-2 mt-2 font-semibold text-white bg-blue-500 rounded">
                                        Inscribir
                                    </button>
                                </form>
                                <ul class="mt-2">
                                    @foreach ($runners as $runner)
                                        @php
                                            $runnerIsInscribed = $race->races->where('runner_id', $runner->id)->isNotEmpty();
                                        @endphp
                                        @if($runnerIsInscribed)
                                            <li class="text-green-500">
                                                El runner {{ $runner->name }} ya está inscrito
                                            </li>
                                        @endif
                                    @endforeach
                                </ul>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection