<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class AdminController extends Controller
{
    /**
     * Daftar seluruh proposal untuk ditinjau dosen / asdos.
     */
    public function index(): View
    {
        $projects = Project::with('user')
            ->latest()
            ->paginate(15);

        return view('admin.index', compact('projects'));
    }

    public function editNilai(Project $project): View
    {
        Gate::authorize('kelola-nilai');

        return view('admin.nilai', compact('project'));
    }

    public function updateNilai(Request $request, Project $project): RedirectResponse
    {
        Gate::authorize('kelola-nilai');

        $data = $request->validate([
            'nilai' => ['required', 'numeric', 'between:0,100'],
            'catatan_review' => ['nullable', 'string', 'max:2000'],
        ]);

        // nilai & catatan_review tidak ada di $fillable, jadi diisi eksplisit.
        $project->nilai = $data['nilai'];
        $project->catatan_review = $data['catatan_review'] ?? null;
        $project->save();

        return redirect()->route('admin.index')
            ->with('status', "Nilai untuk \"{$project->judul}\" berhasil disimpan.");
    }
}
