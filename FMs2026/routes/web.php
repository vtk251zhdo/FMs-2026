<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;


Route::view('/', 'home');

Route::get('/login', [AuthController::class, 'showLogin']);
Route::post('/login', [AuthController::class, 'login']);

Route::get('/register', [AuthController::class, 'showRegister']);
Route::post('/register', [AuthController::class, 'register']);

Route::get('/logout', [AuthController::class, 'logout']);

Route::get('/dashboard', function () {
    if (!session()->has('user_id')) {
        return redirect('/login');
    }

    return view('dashboard');
});

Route::view('/players', 'players.index');
Route::view('/clubs', 'clubs.index');
Route::view('/matches', 'matches.index');
Route::view('/transfers', 'transfers.index');
Route::view('/tournaments', 'tournaments.index');


