<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/',[DashboardController::class,'home'])->middleware(['auth', 'verified'])->name('dashboard');
Route::get('/runners-recruitment/{runner}',[DashboardController::class,'runnersRecruitment'])->middleware(['auth', 'verified'])->name('runners-recruitment');
Route::get('/calendar',[DashboardController::class,'showCalendar'])->middleware(['auth', 'verified'])->name('showCalendar');

Route::post('/runner-inscription/{calendar}', [DashboardController::class, 'runnerInscription'])->name('runnerInscription');
Route::put('/storerunner/{runner}',[DashboardController::class,'storeRunner'])->middleware(['auth', 'verified'])->name('storeRunner');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
