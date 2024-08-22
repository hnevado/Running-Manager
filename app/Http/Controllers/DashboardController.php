<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Runner;

class DashboardController extends Controller
{
    public function home()
    {
        $runners = Runner::latest()->orderBy('id','DESC')->paginate();
        return view('dashboard', ['runners' => $runners]);
    }
}
