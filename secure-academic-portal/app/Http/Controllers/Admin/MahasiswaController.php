<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\View\View;

class MahasiswaController extends Controller implements HasMiddleware
{
    /**
     * Pengganti constructor middleware ($this->middleware()) di Laravel 11+:
     * staf hanya boleh melihat, sedangkan hapus data khusus admin.
     *
     * @return list<Middleware>
     */
    public static function middleware(): array
    {
        return [
            new Middleware('permission:lihat-data', only: ['index']),
            new Middleware('permission:hapus-data', only: ['destroy']),
        ];
    }

    /**
     * Tabel mahasiswa dengan pencarian nama/NRP/email dan filter departemen.
     */
    public function index(Request $request): View
    {
        $filters = $request->validate([
            'search' => ['nullable', 'string', 'max:100'],
            'department' => ['nullable', 'string', 'max:150'],
        ]);

        $search = $filters['search'] ?? null;
        $department = $filters['department'] ?? null;

        $mahasiswas = User::role(User::ROLE_MAHASISWA)
            ->withCount('projects')
            ->when($search, function (Builder $query, string $search) {
                // Sub-query closure agar OR tidak keluar dari filter peran mahasiswa.
                $query->where(function (Builder $q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('nrp', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                });
            })
            ->when($department, fn (Builder $query, string $department) => $query->where('department', $department))
            ->orderBy('name')
            ->paginate(10)
            ->withQueryString();

        $departments = User::role(User::ROLE_MAHASISWA)
            ->distinct()
            ->orderBy('department')
            ->pluck('department');

        return view('admin.mahasiswa.index', compact('mahasiswas', 'departments', 'search', 'department'));
    }

    public function destroy(User $mahasiswa): RedirectResponse
    {
        // Endpoint ini hanya untuk akun mahasiswa, bukan admin atau staf.
        abort_unless($mahasiswa->hasRole(User::ROLE_MAHASISWA), 404);

        $mahasiswa->delete();

        return redirect()->back(fallback: route('admin.mahasiswa.index'))
            ->with('status', "Data mahasiswa \"{$mahasiswa->name}\" beserta proposalnya berhasil dihapus.");
    }
}
