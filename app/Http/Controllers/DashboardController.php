<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Runner;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function home()
    {
        $runners = Runner::latest()->orderBy('id','ASC')->paginate();
        return view('dashboard', ['runners' => $runners]);
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
