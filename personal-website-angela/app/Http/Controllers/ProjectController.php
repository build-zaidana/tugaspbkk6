<?php

namespace App\Http\Controllers;

use App\Models\Project;

class ProjectController extends Controller
{
    /**
     * UC3 — Melihat daftar Projects Pribadi Author.
     */
    public function index()
    {
        $projects = Project::orderByDesc('year')->get();

        return view('projects.index', [
            'projects' => $projects,
        ]);
    }

    /**
     * UC3 (detail) — Melihat detail satu project.
     */
    public function show(Project $project)
    {
        return view('projects.show', [
            'project' => $project,
        ]);
    }
}
