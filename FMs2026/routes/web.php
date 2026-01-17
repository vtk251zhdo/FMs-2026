<?php

use Illuminate\Support\Facades\Route;


Route::view('/', 'home');

Route::view('/login', 'auth.login');
Route::view('/register', 'auth.register');

Route::view('/dashboard', 'dashboard');

Route::view('/players', 'players.index');
Route::view('/clubs', 'clubs.index');
Route::view('/matches', 'matches.index');
Route::view('/transfers', 'transfers.index');
Route::view('/tournaments', 'tournaments.index');


