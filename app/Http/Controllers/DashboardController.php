<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Runner;
use App\Models\User;
use App\Models\Workout;
use App\Models\Sneaker;
use App\Models\Race;
use App\Models\Calendar;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Jobs\SimulateRaceProgress;

class DashboardController extends Controller
{
    public function home()
    {
        $user = Auth::user();

        $runners = Runner::where('user_id',$user->id)->get();
        //Estadísticas 

        $numberRunners = Runner::where('user_id',$user->id)->count();
        $injuryRunners = Runner::where('user_id',$user->id)->where('is_injury', 1)->count();

        // Obtener la próxima carrera
        $nextRace = Race::join('calendars', 'races.calendar_id', '=', 'calendars.id')
        ->where('calendars.race_date', '>=', Carbon::today())
        ->where('races.runner_id', $user->id)
        ->orderBy('calendars.race_date', 'asc')
        ->select('races.*', 'calendars.race_date')
        ->first();

        $nextRaceDate = $nextRace ? $nextRace->calendar->race_date : 'Sin carreras';
        $calendarId = $nextRace ? $nextRace->calendar->id : 0;

        // Pasamos los runners y estadísticas a la vista dashboard 
        return view('dashboard', ['runners' => $runners, 'numberRunners' => $numberRunners, 'injuryRunners' => $injuryRunners, 'nextRaceDate' => $nextRaceDate, 'calendarId' => $calendarId]);
       
    }

    public function runnersRecruitment(Runner $runner)
    {

        return view('runners-recruitment', ['runner' => $runner]);

    }

    public function storeRunner(Request $request, Runner $runner)
    {
        $user = Auth::user();
        $balance = $user->balance - $runner->price;
    
        if ($balance >= 0) {

            // Actualizo el balance del usuario
            $user->update(['balance' => $balance]);
    
            // Asocio el runner al usuario actual
            $runner->update(['user_id' => $user->id]);
    
            return back()->with('success', '¡Runner contratado con éxito!');
        } else {

            return back()->with('error', 'No tienes suficiente saldo para contratar a este runner. Tu saldo es de '.$user->balance." euros");
        }

    }

    public function showCalendar()
    {

        $userId = Auth::user()->id;

        // Obtengo los runners del usuario autenticado
        $runners = auth()->user()->runners;

        // Próximas 30 carreras con sus inscripciones
        $calendar = Calendar::where('race_date', '>=', Carbon::today())
            ->orderBy('race_date', 'asc')
            ->with('races') // Cargar todas las inscripciones relacionadas con la carrera
            ->take(30)
            ->get();

        return view('calendar',['calendar' => $calendar, 'runners' => $runners]);

    }

    public function runnerInscription(Request $request, Calendar $calendar)
    {

        $user = Auth::user();

        // Verificamos que el runner pertenece al usuario
        Runner::where('id', $request->runner_id)->where('user_id', $user->id)->firstOrFail();
        
        // Verificamos si el usuario ya está inscrito
        $alreadyRegistered = Race::where('runner_id', $request->runner_id)->where('calendar_id', $calendar->id)->exists();

        if ($calendar->is_closed)
          return redirect()->back()->with('error', 'La carrera '.$calendar->race_name.' ya no admite más inscripciones.');

        if (!$alreadyRegistered) {

            $balance = $user->balance - $calendar->entry_fee;

            if ($balance >= 0) {

                // Actualizo el balance del usuario
                $user->update(['balance' => $balance]);

                //Guardo su inscripción
                Race::create([
                    'runner_id' => $request->runner_id,
                    'calendar_id' => $calendar->id,
                ]);

                return redirect()->back()->with('success', 'Te has inscrito con éxito a la carrera '.$calendar->race_name.'.');
           }

           return redirect()->back()->with('error', 'No tienes suficiente saldo para participar en la carrera '.$calendar->race_name.'.');

        }

        return redirect()->back()->with('error', 'Ya estás inscrito en esta carrera.');


    }

    public function showRunners(Request $request)
    {

        // Inicializamos la consulta de runners
        $query = Runner::query();

        // Ordenación dinámica según la solicitud
        $sortBy = $request->input('sort_by', 'id'); // Campo de ordenación por defecto es 'id'
        $sortDirection = $request->input('sort_direction', 'asc'); // Dirección por defecto es 'asc'
        
        $query->orderBy($sortBy, $sortDirection);
        
        // Paginamos los resultados y agregamos los parámetros de ordenación a la URL
        $runners = $query->paginate()->appends([
            'sort_by' => $sortBy,
            'sort_direction' => $sortDirection,
        ]);

        return view('runners',['runners' => $runners]);
    }

    public function showSneakers()
    {

        $runners_ids = auth()->user()->runners->pluck('id');
        
        // Obtengo los sneakers del usuario autenticado

        $sneakers = Sneaker::whereIn('runner_id',$runners_ids)->with('runner')->get();

        return view('sneakers',['sneakers' => $sneakers]);

    }

    public function showWorkout()
    {
        $user = auth()->user();
        $runners = $user->runners;

        // Verificamos si hay entrenamientos activos
        $activeWorkout = Workout::whereIn('runner_id', $runners->pluck('id'))
            ->where('end_workout', '>=', now())
            ->with('runner')
            ->first(); // Solo queremos el primer entrenamiento activo

        // Obtenemos los logs de entrenamientos previos
        $previousWorkouts = Workout::whereIn('runner_id', $runners->pluck('id'))
        ->where('end_workout', '<', Carbon::now())
        ->with('runner')
        ->orderBy('end_workout', 'desc')
        ->get();
 
        return view('workout', ['runners' => $runners, 'activeWorkout' => $activeWorkout, 'previousWorkouts' => $previousWorkouts]);
    }

    public function assignWorkout(Request $request)
    {
        $validated = $request->validate([
            'runner_id' => 'required|exists:runners,id',
            'type' => 'required|in:Rodaje,Series cortas,Series largas,Sesión de fuerza,Ejercicios de fortalecimiento y core',
            'intensity' => 'required|integer|min:1|max:10',
            'distance' => 'nullable|integer',
        ]);

        // Comprobar si ya hay un entrenamiento activo
        $activeWorkout = Workout::where('runner_id', $validated['runner_id'])
            ->where('end_workout', '>=', now())
            ->first();

        if ($activeWorkout) {
            return back()->withErrors('El corredor ya tiene un entrenamiento activo.');
        }

        // Calculamos la duración
        $duration = $validated['type'] === 'Ejercicios de fortalecimiento y core' ? 60 : ($validated['distance'] * 6);

        // Establecemos la fecha fin del entrenamiento
        $endWorkout = now()->addMinutes($duration);

        // Creamos el entrenamiento
        Workout::create([
            'runner_id' => $validated['runner_id'],
            'type' => $validated['type'],
            'intensity' => $validated['intensity'],
            'distance' => $validated['distance'],
            'end_workout' => $endWorkout,
            'log' => "Entrenamiento de {$validated['type']} con intensidad {$validated['intensity']}",
        ]);

        return redirect()->route('showWorkout')->with('success', 'Entrenamiento asignado correctamente.');
    }

    public function startRaceSimulation($calendarId)
    {
        $calendar = Calendar::findOrFail($calendarId);

        // Despachar el job SimulateRaceProgress a la cola
        SimulateRaceProgress::dispatch($calendar);

        return redirect()->route('showRaceProgress', ['calendarId' => $calendarId])
                        ->with('status', 'La simulación de la carrera ha comenzado.');
    }

    public function showRaceProgress($calendarId)
    {
        // Obtener la carrera (calendar) y los corredores inscritos
        $calendar = Calendar::findOrFail($calendarId);
        $runners = Race::where('calendar_id', $calendarId)->with('runner')->get();
        
        // Obtener el log de progreso almacenado
        //$progressLog = $calendar->progress_log;

        // Pasar los datos a la vista
        return view('race_progress', [
            'calendar' => $calendar,
            'runners' => $runners
        ]);
    }

}
