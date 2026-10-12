<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCourseTaskRequest;
use App\Models\CourseTask;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;

class CourseTaskController extends Controller
{
    public function store(StoreCourseTaskRequest $request): RedirectResponse
    {
        $request->user()->courseTasks()->create($request->validated());

        return redirect()->route('dashboard')->with('status', 'Riwayat tugas berhasil ditambahkan.');
    }

    public function destroy(CourseTask $courseTask): RedirectResponse
    {
        Gate::authorize('delete', $courseTask);
        $courseTask->delete();

        return redirect()->route('dashboard')->with('status', 'Riwayat tugas berhasil dihapus.');
    }
}
