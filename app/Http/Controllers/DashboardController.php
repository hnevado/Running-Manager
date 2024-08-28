<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Runner;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function home(Request $request)
    {
        // Inicializamos la consulta de runners
        $query = Runner::query();

        // Ordenación dinámica según la solicitud
        if ($request->has('sort_by') && $request->has('sort_direction')) {
            $query->orderBy($request->input('sort_by'), $request->input('sort_direction'));
        } else {
            // Ordenación predeterminada si no hay parámetros de ordenación en la solicitud
            $query->orderBy('id', 'ASC');
        }

        // Paginamos los resultados
        $runners = $query->paginate();

        // Pasamos los runners a la vista dashboard con un include para la lista de runners
        return view('dashboard', ['runners' => $runners]);

        /*
        $runners = Runner::latest()->orderBy('id','ASC')->paginate();
        return view('dashboard', ['runners' => $runners]);
        */
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
