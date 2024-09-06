@extends('dashboard/app')

@section('pageTitle', 'Dashboard')

@section('stats')
<div class="w-full px-6 sm:w-1/2 xl:w-1/3">
                                <div class="flex items-center px-5 py-6 bg-white rounded-md shadow-sm">
                                    <div class="p-3 bg-indigo-600 bg-opacity-75 rounded-full">
                                        <svg class="w-8 h-8 text-white" viewBox="0 0 28 30" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M18.2 9.08889C18.2 11.5373 16.3196 13.5222 14 13.5222C11.6804 13.5222 9.79999 11.5373 9.79999 9.08889C9.79999 6.64043 11.6804 4.65556 14 4.65556C16.3196 4.65556 18.2 6.64043 18.2 9.08889Z"
                                                fill="currentColor"></path>
                                            <path
                                                d="M25.2 12.0444C25.2 13.6768 23.9464 15 22.4 15C20.8536 15 19.6 13.6768 19.6 12.0444C19.6 10.4121 20.8536 9.08889 22.4 9.08889C23.9464 9.08889 25.2 10.4121 25.2 12.0444Z"
                                                fill="currentColor"></path>
                                            <path
                                                d="M19.6 22.3889C19.6 19.1243 17.0927 16.4778 14 16.4778C10.9072 16.4778 8.39999 19.1243 8.39999 22.3889V26.8222H19.6V22.3889Z"
                                                fill="currentColor"></path>
                                            <path
                                                d="M8.39999 12.0444C8.39999 13.6768 7.14639 15 5.59999 15C4.05359 15 2.79999 13.6768 2.79999 12.0444C2.79999 10.4121 4.05359 9.08889 5.59999 9.08889C7.14639 9.08889 8.39999 10.4121 8.39999 12.0444Z"
                                                fill="currentColor"></path>
                                            <path
                                                d="M22.4 26.8222V22.3889C22.4 20.8312 22.0195 19.3671 21.351 18.0949C21.6863 18.0039 22.0378 17.9556 22.4 17.9556C24.7197 17.9556 26.6 19.9404 26.6 22.3889V26.8222H22.4Z"
                                                fill="currentColor"></path>
                                            <path
                                                d="M6.64896 18.0949C5.98058 19.3671 5.59999 20.8312 5.59999 22.3889V26.8222H1.39999V22.3889C1.39999 19.9404 3.2804 17.9556 5.59999 17.9556C5.96219 17.9556 6.31367 18.0039 6.64896 18.0949Z"
                                                fill="currentColor"></path>
                                        </svg>
                                    </div>
    
                                    <div class="mx-5">
                                        <h4 class="text-2xl font-semibold text-gray-700">{{$numberRunners}}</h4>
                                        <div class="text-gray-500">Runner(s) entrenados por ti</div>
                                    </div>
                                </div>
                            </div>
    
                            <div class="w-full px-6 mt-6 sm:w-1/2 xl:w-1/3 sm:mt-0">
                                <div class="flex items-center px-5 py-6 bg-white rounded-md shadow-sm">
                                    <div class="p-3 bg-orange-600 bg-opacity-75 rounded-full">
                                    <svg class="w-8 h-8 text-white" viewBox="0 0 340 340" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                            <defs><linearGradient gradientUnits="userSpaceOnUse" id="New_Gradient_Swatch_6" x1="140.734" x2="146.755" y1="-3.076" y2="129.389"><stop offset="0" stop-color="#fcd0be"/><stop offset="1" stop-color="#efa69a"/></linearGradient><radialGradient cx="85.302" cy="291.058" gradientUnits="userSpaceOnUse" id="radial-gradient" r="82.013"><stop offset="0" stop-color="#f97d7d"/><stop offset="1" stop-color="#fcd0be"/></radialGradient><linearGradient gradientUnits="userSpaceOnUse" id="linear-gradient" x1="109.191" x2="181.716" y1="268.262" y2="341.276"><stop offset="0" stop-color="#f3f8ff"/><stop offset="1" stop-color="#c9d4e5"/></linearGradient></defs><title/><path d="M98.7,10s23.831,16.987,78.017,23.063a14.9,14.9,0,0,1,13.193,14.822v83.04H116.847l-3.63-70.336S99.6,56.5,95.973,43.345l12.706-3.631S95.973,32.47,98.7,10Z" style="fill:url(#New_Gradient_Swatch_6)"/><path d="M142.94,130.925v31.794L96.8,183.786A21.47,21.47,0,0,0,85.053,197.45C79.2,218.056,66.6,268.842,67.662,321.259L183.213,330h93.669a988.872,988.872,0,0,0-23.974-132.351,21.463,21.463,0,0,0-11.192-13.826l-51.81-25.918v-26.98Z" style="fill:url(#radial-gradient)"/><polygon points="189.906 130.925 142.94 130.925 142.94 162.719 189.906 141.276 189.906 130.925" style="fill:#464965"/><path d="M228.752,282.568a46.168,46.168,0,0,0-14.129-24.5,7.055,7.055,0,0,1-2.173-6.888c9.113-39.147,9.113-77.44,9.113-77.442h-6.571l-26.749,81.214H121.984l-4.525-80.6-9.347,74.88a13.556,13.556,0,0,1-6.746,10.1l-.056.032A56.148,56.148,0,0,0,77,286.317h100.91L163.526,330h45.191c9.439-2.654,14.761-10.5,17.724-17.679A49.4,49.4,0,0,0,228.752,282.568Z" style="fill:#cc6262"/><polygon points="117.459 174.353 142.94 162.719 139.17 270.234 117.459 270.234 117.459 174.353" style="fill:#464965"/><path d="M121.331,263.377a51.406,51.406,0,0,0-8.342.678l-12.4,3.739A47.939,47.939,0,0,0,95,270.777c-10.76,6.706-24.183,18.5-29.623,37.45,0,0,137.773,10.656,141.108-4.221a33.419,33.419,0,0,0,.806-7.318h0a33.311,33.311,0,0,0-33.311-33.311H135.718a18.569,18.569,0,0,1-8.292,0Z" style="fill:url(#linear-gradient)"/><path d="M206.479,304a32.467,32.467,0,0,1-16.573,4.225H65.389a63.272,63.272,0,0,0-2.228,12.234A8.943,8.943,0,0,0,72.215,330H173.983A33.317,33.317,0,0,0,206.479,304Z" style="fill:#464965"/><path d="M154.326,110.2a13.231,13.231,0,0,1-6.514-1.706l-.322-.182a6.228,6.228,0,0,0-5.211-.43l-5.219,1.907a3.5,3.5,0,0,1-2.4-6.574l5.219-1.907a13.223,13.223,0,0,1,11.057.91l.323.182a6.262,6.262,0,0,0,6.187-.027,13.152,13.152,0,0,1,11.494-.838l2.088.828a3.5,3.5,0,1,1-2.582,6.506l-2.087-.828a6.209,6.209,0,0,0-5.415.4A13.244,13.244,0,0,1,154.326,110.2Z" style="fill:#cc6262"/><path d="M202.385,164.147S173.425,282.5,142.94,330h25.4s38.959-73.03,53.228-156.259Z" style="fill:#464965"/><path d="M243.281,180.693,223.13,170.612h0l-6.931-3.467-22.792-11.4V47.885a18.37,18.37,0,0,0-16.3-18.3C124.666,23.705,100.955,7.31,100.721,7.145a3.5,3.5,0,0,0-5.5,2.434c-1.789,14.768,2.621,23.662,6.537,28.473l-6.747,1.927a3.5,3.5,0,0,0-2.412,4.3c3.16,11.456,12.734,16.825,17.24,18.771l3.513,68.059a3.5,3.5,0,0,0,3.495,3.32H139.44V160.47L95.343,180.6a24.94,24.94,0,0,0-13.657,15.891c-5.6,19.706-15.285,59.33-17.242,103.3a3.387,3.387,0,0,0,.025.452,65.4,65.4,0,0,0-4.8,19.927,12.045,12.045,0,0,0,3.2,9.248,12.724,12.724,0,0,0,9.347,4.08H173.983a36.8,36.8,0,0,0,25.54-63.309A541.419,541.419,0,0,0,224.2,178.972l15.955,7.981a17.948,17.948,0,0,1,9.368,11.568c16.758,65.1,23.321,126.4,23.846,131.479h7a3.288,3.288,0,0,0,0-.344c-.063-.639-6.518-64.7-24.068-132.879A24.94,24.94,0,0,0,243.281,180.693ZM188.34,161.035l10.092,5.049c-2.2,10.9-11.421,54.255-25.945,93.793H143.036L146.362,165l40.044-18.282v11.183A3.5,3.5,0,0,0,188.34,161.035Zm-18.5,105.842a268.927,268.927,0,0,1-13.008,28.837c-3.325-11.839-2.027-24.56-1.434-28.837Zm-23.4-109.6V134.425h39.966v4.6Zm-26.269-29.849-3.459-67.017a3.5,3.5,0,0,0-2.49-3.172c-.1-.031-9.481-2.939-13.651-11.565l9.069-2.591a3.512,3.512,0,0,0,.8-6.387c-.392-.235-8.694-5.412-8.633-20.733,9.74,5.321,33.574,15.991,74.511,20.581a11.374,11.374,0,0,1,10.083,11.344v79.54ZM148.33,266.877c-.829,6.452-2.089,22.857,3.919,36.894-.2.322-.395.64-.593.958H124.265c.107-26.751,9.747-36.024,12.256-37.852Zm-31.067,37.852H94.137c2.026-23.333,14.2-34.5,16.96-36.736a47.731,47.731,0,0,1,10.234-1.116h6.032C123.175,272.858,117.328,284.779,117.263,304.729Zm3.7-128.127,18.284-8.347-3.212,91.622h-14.7c-.124,0-.248,0-.372.006Zm-32.539,21.8a17.951,17.951,0,0,1,9.831-11.436l15.708-7.172v80.573c-1.727.233-3.433.552-5.116.946l-.045.01a52.155,52.155,0,0,0-15.646,6.48,76.678,76.678,0,0,0-20.863,18.8A472.4,472.4,0,0,1,88.42,198.406Zm8.434,75.342c.1-.064.21-.117.313-.18-4.482,6.942-8.948,17.163-10.058,31.161H70.239C75.994,289.578,87.245,279.736,96.854,273.748ZM203.8,296.681a29.91,29.91,0,0,1-.429,5.031,29.652,29.652,0,0,1-13.263,3.026c-.063,0-5.1,0-5.1,0,2.568-5.3,6.81-14.549,11.741-27.265A29.83,29.83,0,0,1,203.8,296.681Zm-27.558,9.873c-1.2,2.651-.138,5.175,3.073,5.175l11.278.014a37.575,37.575,0,0,0,9.888-1.42,29.836,29.836,0,0,1-26.5,16.177H72.215a5.706,5.706,0,0,1-4.2-1.82,5.12,5.12,0,0,1-1.37-3.926,60.415,60.415,0,0,1,1.436-9.025h85.507a3.335,3.335,0,0,0,2.925-1.585c.006-.009.014-.015.02-.024q1.355-2.112,2.676-4.344l0,0c25.539-43.04,41.79-117.208,45.709-136.439l12.744,6.375C203.546,255.831,176.515,306.05,176.241,306.554Z" style="fill:#464965"/>
                                        </svg>
                                    </div>
    
                                    <div class="mx-5">
                                        <h4 class="text-2xl font-semibold text-gray-700">{{$injuryRunners}}</h4>
                                        <div class="text-gray-500">Runner(s) lesionados</div>
                                    </div>
                                </div>
                            </div>
    
                            <div class="w-full px-6 mt-6 sm:w-1/2 xl:w-1/3 xl:mt-0">
                                <div class="flex items-center px-5 py-6 bg-white rounded-md shadow-sm">
                                    <div class="p-3 bg-pink-600 bg-opacity-75 rounded-full">
                                    <svg class="w-8 h-8 text-white" xmlns="http://www.w3.org/2000/svg" xmlns:cc="http://creativecommons.org/ns#" xmlns:dc="http://purl.org/dc/elements/1.1/" xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#"><g transform="translate(0 -1028.4)"><path d="m5 1032.4c-1.1046 0-2 0.9-2 2v14c0 1.1 0.8954 2 2 2h6 2 6c1.105 0 2-0.9 2-2v-14c0-1.1-0.895-2-2-2h-6-2-6z" fill="#bdc3c7"/><path d="m5 3c-1.1046 0-2 0.8954-2 2v14c0 1.105 0.8954 2 2 2h6 2 6c1.105 0 2-0.895 2-2v-14c0-1.1046-0.895-2-2-2h-6-2-6z" fill="#ecf0f1" transform="translate(0 1028.4)"/><path d="m5 1031.4c-1.1046 0-2 0.9-2 2v3h18v-3c0-1.1-0.895-2-2-2h-6-2-6z" fill="#e74c3c"/><path d="m7 5.5a1.5 1.5 0 1 1 -3 0 1.5 1.5 0 1 1 3 0z" fill="#c0392b" transform="translate(.5 1028.4)"/><path d="m6 1c-0.5523 0-1 0.4477-1 1v3c0 0.5523 0.4477 1 1 1s1-0.4477 1-1v-3c0-0.5523-0.4477-1-1-1z" fill="#bdc3c7" transform="translate(0 1028.4)"/><path d="m7 5.5a1.5 1.5 0 1 1 -3 0 1.5 1.5 0 1 1 3 0z" fill="#c0392b" transform="translate(12.5 1028.4)"/><g fill="#bdc3c7"><path d="m18 1029.4c-0.552 0-1 0.4-1 1v3c0 0.5 0.448 1 1 1s1-0.5 1-1v-3c0-0.6-0.448-1-1-1z"/><path d="m5 1039.4v2h2v-2h-2zm3 0v2h2v-2h-2zm3 0v2h2v-2h-2zm3 0v2h2v-2h-2zm3 0v2h2v-2h-2z"/><path d="m5 1042.4v2h2v-2h-2zm3 0v2h2v-2h-2zm3 0v2h2v-2h-2zm3 0v2h2v-2h-2zm3 0v2h2v-2h-2z"/><path d="m5 1045.4v2h2v-2h-2zm3 0v2h2v-2h-2zm3 0v2h2v-2h-2zm3 0v2h2v-2h-2zm3 0v2h2v-2h-2z"/></g><rect fill="#c0392b" height="1" transform="translate(0 1028.4)" width="18" x="3" y="8"/></g>
                                    </svg>
                                    </div>
    
                                    <div class="mx-5">
                                        <h4 class="text-2xl font-semibold text-gray-700">{{$nextRaceDate}}</h4>
                                        <div class="text-gray-500">Próxima carrera</div>
                                    </div>
                                </div>
                            </div>
@endsection

@section('content')
    @forelse ($runners as $runner)
    <div class="w-full mx-auto p-6 bg-white shadow-lg rounded-lg">
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
                        <p class="text-sm text-gray-600">Peso: {{ $runner->weight }} kg</p>
                        <p class="text-sm text-gray-600">Altura: {{ $runner->height }} m</p>
                        <p class="text-sm text-gray-600">Nacionalidad: {{ $runner->nationality }}</p>
                        <p class="text-sm text-gray-600">Media: {{ $runner->media }}</p>
                    </div>
                    <div class="md:text-right">
                        <h3 class="text-2xl font-semibold text-gray-700">{{ $runner->age }} años</h3>
                        <p class="text-xl {{ $runner->is_injury ? 'text-red-500' : 'text-blue-500' }} font-bold">
                            {{$runner->is_injury ? 'Lesionado/a': 'Saludable'}}</p>
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
                    <div>
                        <h4 class="font-semibold text-gray-700">Nivel de fatiga</h4>
                        <div class="w-full bg-gray-200 rounded-full h-4">
                            <div title="{{ $runner->tired }}" class="bg-orange-200 h-4 rounded-l-full" style="width: {{ $runner->tired }}%;"></div>
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
            </div>
        </div>
      </div>
    @empty
        <p>¡Aún no has contratado ningún runner! <a href="{{route('showRunners')}}">Contratar runner</a></p>
    @endforelse
@endsection