<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Runner;
use App\Models\User;
use App\Models\Race;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function home(Request $request)
    {
        $user = Auth::user();
       //Listado de runners a contratar

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

        // Pasamos los runners y estadísticas a la vista dashboard 
        return view('dashboard', ['runners' => $runners, 'numberRunners' => $numberRunners, 'injuryRunners' => $injuryRunners, 'nextRaceDate' => $nextRaceDate]);
       
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
}
