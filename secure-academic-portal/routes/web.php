<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CourseTaskController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
| 1. Area Publik (akses bebas)
*/
Route::get('/', [PageController::class, 'index'])->name('home');
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/project-idea', [PageController::class, 'project'])->name('project-idea');
Route::get('/hitung/{angka1}/{angka2}/{operasi}', [PageController::class, 'hitung'])->name('hitung');

/*
| 2. Area Mahasiswa (hanya user login)
*/
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', DashboardController::class)->name('dashboard');
    Route::post('/course-tasks', [CourseTaskController::class, 'store'])->name('course-tasks.store');
    Route::delete('/course-tasks/{courseTask}', [CourseTaskController::class, 'destroy'])->name('course-tasks.destroy');

    Route::get('/projects/create', [ProjectController::class, 'create'])->name('projects.create');
    Route::post('/projects', [ProjectController::class, 'store'])
        ->middleware('throttle:submit-proposal')
        ->name('projects.store');
    Route::get('/projects/{project}/edit', [ProjectController::class, 'edit'])->name('projects.edit');
    Route::put('/projects/{project}', [ProjectController::class, 'update'])->name('projects.update');
    Route::delete('/projects/{project}', [ProjectController::class, 'destroy'])->name('projects.destroy');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/*
| 3. Area Dosen / Asisten Dosen (hanya role tertentu)
*/
Route::middleware(['auth', 'cek.peran:dosen,asdos'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/', [AdminController::class, 'index'])->name('index');
        Route::get('/projects/{project}/nilai', [AdminController::class, 'editNilai'])->name('nilai.edit');
        Route::put('/projects/{project}/nilai', [AdminController::class, 'updateNilai'])->name('nilai.update');
    });

/*
| Tantangan A+: Auto-login akun demo (hanya aktif di environment local)
*/
if (app()->environment('local')) {
    Route::get('/login/as/{role}', function (string $role) {
        $user = User::where('role', $role)->orderBy('id')->first();

        if (! $user) {
            return redirect()->route('login')->with('status', 'Akun uji coba tidak ditemukan!');
        }

        Auth::login($user);
        request()->session()->regenerate();

        return redirect()->route('dashboard');
    })->middleware('guest')
        ->whereIn('role', [User::ROLE_DOSEN, User::ROLE_ASDOS, User::ROLE_MAHASISWA])
        ->name('login.as');
}

require __DIR__.'/auth.php';
