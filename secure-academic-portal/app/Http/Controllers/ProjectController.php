<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class ProjectController extends Controller
{
    public function create(): View
    {
        return view('projects.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request);

        $request->user()->projects()->create($data);

        return redirect()->route('dashboard')
            ->with('status', 'Proposal proyek berhasil diajukan.');
    }

    public function edit(Project $project): View
    {
        Gate::authorize('update', $project);

        return view('projects.edit', compact('project'));
    }

    public function update(Request $request, Project $project): RedirectResponse
    {
        Gate::authorize('update', $project);

        $data = $this->validated($request);

        // Kosongkan input API key = tetap pakai key lama.
        if (blank($data['api_key_secure'] ?? null)) {
            unset($data['api_key_secure']);
        }

        $project->update($data);

        return redirect()->route('dashboard')
            ->with('status', 'Proposal proyek berhasil diperbarui.');
    }

    public function destroy(Project $project): RedirectResponse
    {
        Gate::authorize('delete', $project);

        $project->delete();

        return redirect()->route('dashboard')
            ->with('status', 'Proposal proyek berhasil dihapus.');
    }

    /**
     * @return array<string, mixed>
     */
    private function validated(Request $request): array
    {
        $data = $request->validate([
            'judul' => ['required', 'string', 'max:150'],
            'deskripsi' => ['nullable', 'string', 'max:5000'],
            'tema_agent' => ['nullable', 'string', 'max:50'],
            'api_key_secure' => ['nullable', 'string', 'max:255'],
        ]);

        $data['tema_agent'] = $data['tema_agent'] ?? 'Ollama';

        return $data;
    }
}
