<?php

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\MahasiswaController;
use App\Http\Controllers\Admin\ProposalController;
use App\Http\Controllers\Admin\UserRoleController;
use App\Http\Controllers\CourseTaskController;
use App\Http\Controllers\DashboardController;
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
| 3. Panel Admin AdminLTE (Pertemuan 10) — hanya peran Spatie admin & staf.
|    Izin per aksi (lihat-data, kelola-nilai, hapus-data, kelola-pengguna)
|    dikunci lagi di masing-masing controller lewat middleware permission:.
*/
Route::middleware(['auth', 'role:admin|staf'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/', fn () => redirect()->route('admin.dashboard'))->name('index');
        Route::get('/dashboard', AdminDashboardController::class)->name('dashboard');

        Route::get('/mahasiswa', [MahasiswaController::class, 'index'])->name('mahasiswa.index');
        Route::delete('/mahasiswa/{mahasiswa}', [MahasiswaController::class, 'destroy'])->name('mahasiswa.destroy');

        Route::get('/proposals', [ProposalController::class, 'index'])->name('proposals.index');
        Route::get('/proposals/{project}/nilai', [ProposalController::class, 'editNilai'])->name('proposals.nilai.edit');
        Route::put('/proposals/{project}/nilai', [ProposalController::class, 'updateNilai'])->name('proposals.nilai.update');
        Route::delete('/proposals/{project}', [ProposalController::class, 'destroy'])->name('proposals.destroy');

        Route::get('/users', [UserRoleController::class, 'index'])->name('users.index');
        Route::put('/users/{user}/role', [UserRoleController::class, 'update'])->name('users.role.update');
    });

/*
| Tantangan A+: Auto-login akun demo (hanya aktif di environment local)
*/
if (app()->environment('local')) {
    Route::get('/login/as/{role}', function (string $role) {
        $user = User::role($role)->orderBy('id')->first();

        if (! $user) {
            return redirect()->route('login')->with('status', 'Akun uji coba tidak ditemukan!');
        }

        Auth::login($user);
        request()->session()->regenerate();

        return redirect()->route($user->homeRouteName());
    })->middleware('guest')
        ->whereIn('role', array_keys(User::ROLE_LABELS))
        ->name('login.as');
}

require __DIR__.'/auth.php';
