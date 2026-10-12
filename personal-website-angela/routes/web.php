<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\CollectionController;
use App\Http\Controllers\ResumeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes — Personal Website Angela Vania Sugiyono
|--------------------------------------------------------------------------
| Setiap route dipetakan langsung ke satu use case (lihat implementation
| plan). Route lifecycle: Request -> Route -> Controller -> (Model) -> View.
*/

// UC1.1 — Melihat showcase / halaman utama (About Me)
Route::get('/', [HomeController::class, 'index'])->name('home');

// UC2 — Melihat Contact Person Author
Route::get('/contact', [ContactController::class, 'index'])->name('contact');

// UC3 — Melihat Projects Pribadi Author
Route::get('/projects', [ProjectController::class, 'index'])->name('projects.index');
Route::get('/projects/{project:slug}', [ProjectController::class, 'show'])->name('projects.show');

// UC4 — Melihat Personal Collection Author (achievements)
Route::get('/collection', [CollectionController::class, 'index'])->name('collection');

// UC5 — Mendownload resume Author
Route::get('/resume/download', [ResumeController::class, 'download'])->name('resume.download');
