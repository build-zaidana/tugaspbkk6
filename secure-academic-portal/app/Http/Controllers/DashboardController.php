<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Dashboard profil: hanya menampilkan project milik user yang sedang login,
     * diurutkan dari yang terbaru.
     */
    public function __invoke(Request $request): View
    {
        $user = $request->user();

        $projects = $user->projects()
            ->latest()
            ->get();

        $courseTasks = $user->courseTasks()->orderByDesc('tanggal_pengumpulan')->latest()->get();

        return view('dashboard', compact('user', 'projects', 'courseTasks'));
    }
}
