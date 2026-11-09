<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Spatie\Permission\Models\Permission;

class DashboardController extends Controller
{
    /**
     * Beranda panel admin: widget statistik agregat dari kueri count().
     */
    public function __invoke(Request $request): View
    {
        $stats = [
            'mahasiswa' => User::role(User::ROLE_MAHASISWA)->count(),
            'pengajar' => User::role([User::ROLE_ADMIN, User::ROLE_STAF])->count(),
            'proposal' => Project::count(),
            'belumDinilai' => Project::whereNull('nilai')->count(),
        ];

        $latestProposals = Project::with('user')->latest()->limit(5)->get();

        $temaSummary = Project::query()
            ->select('tema_agent')
            ->selectRaw('count(*) as total')
            ->groupBy('tema_agent')
            ->orderByDesc('total')
            ->get();

        $permissions = Permission::orderBy('name')->pluck('name');

        return view('admin.dashboard', [
            'user' => $request->user(),
            'stats' => $stats,
            'latestProposals' => $latestProposals,
            'temaSummary' => $temaSummary,
            'permissions' => $permissions,
        ]);
    }
}
