<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ProposalController extends Controller implements HasMiddleware
{
    /**
     * Staf boleh melihat dan menilai proposal; hapus proposal khusus admin.
     *
     * @return list<Middleware>
     */
    public static function middleware(): array
    {
        return [
            new Middleware('permission:lihat-data', only: ['index']),
            new Middleware('permission:kelola-nilai', only: ['editNilai', 'updateNilai']),
            new Middleware('permission:hapus-data', only: ['destroy']),
        ];
    }

    /**
     * Tabel proposal dengan filter kata kunci, tema agent, dan status penilaian.
     */
    public function index(Request $request): View
    {
        $filters = $request->validate([
            'search' => ['nullable', 'string', 'max:100'],
            'tema' => ['nullable', 'string', 'max:50'],
            'status' => ['nullable', Rule::in(['dinilai', 'belum'])],
        ]);

        $projects = Project::with('user')
            ->when($filters['search'] ?? null, function (Builder $query, string $search) {
                $query->where(function (Builder $q) use ($search) {
                    $q->where('judul', 'like', "%{$search}%")
                        ->orWhereHas('user', fn (Builder $user) => $user->where('name', 'like', "%{$search}%"));
                });
            })
            ->when($filters['tema'] ?? null, fn (Builder $query, string $tema) => $query->where('tema_agent', $tema))
            ->when($filters['status'] ?? null, fn (Builder $query, string $status) => $status === 'dinilai'
                ? $query->whereNotNull('nilai')
                : $query->whereNull('nilai'))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $temaOptions = Project::query()->distinct()->orderBy('tema_agent')->pluck('tema_agent');

        return view('admin.proposals.index', compact('projects', 'temaOptions', 'filters'));
    }

    public function editNilai(Project $project): View
    {
        $project->load('user');

        return view('admin.proposals.nilai', compact('project'));
    }

    public function updateNilai(Request $request, Project $project): RedirectResponse
    {
        $data = $request->validate([
            'nilai' => ['required', 'numeric', 'between:0,100'],
            'catatan_review' => ['nullable', 'string', 'max:2000'],
        ]);

        // nilai & catatan_review tidak ada di $fillable, jadi diisi eksplisit.
        $project->nilai = $data['nilai'];
        $project->catatan_review = $data['catatan_review'] ?? null;
        $project->save();

        return redirect()->route('admin.proposals.index')
            ->with('status', "Nilai untuk \"{$project->judul}\" berhasil disimpan.");
    }

    public function destroy(Project $project): RedirectResponse
    {
        $project->delete();

        return redirect()->back(fallback: route('admin.proposals.index'))
            ->with('status', "Proposal \"{$project->judul}\" berhasil dihapus.");
    }
}
