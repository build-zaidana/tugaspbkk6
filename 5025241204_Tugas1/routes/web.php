<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;


// 1. Home
Route::get('/', [PageController::class, 'index'])->name('home');

// 2. About
Route::get('/about', [PageController::class, 'about'])->name('about');

// 3. Project
Route::get('/project-idea', [PageController::class, 'project'])->name('project');

// 4. Calculator
Route::get('/calculator', [PageController::class, 'calculator'])->name('calculator');