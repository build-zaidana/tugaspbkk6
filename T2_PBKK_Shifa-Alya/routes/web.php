<?php

use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PageController::class, 'index'])
    ->name('home');

Route::get('/mahasiswa/{nrp}', [PageController::class, 'student'])
    ->where('nrp', '[0-9]{10}')
    ->name('mahasiswa.profil');

Route::get('/agent/{tema?}', [PageController::class, 'agent'])
    ->name('agent');

Route::get('/hitung-ipk/{ipk1}/{ipk2}', [PageController::class, 'ipk'])
    ->name('ipk.hitung');