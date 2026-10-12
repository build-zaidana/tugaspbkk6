<?php

use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PageController::class,'index']);
Route::get('/about', [PageController::class,'about']);
Route::get('/project-idea', [PageController::class,'project']);
Route::get('/hitung/{angka1}/{angka2}/{operasi}', [PageController::class,'hitung']);
