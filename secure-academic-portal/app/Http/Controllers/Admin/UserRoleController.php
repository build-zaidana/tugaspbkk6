<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class UserRoleController extends Controller implements HasMiddleware
{
    /**
     * Manajemen peran pengguna khusus admin.
     *
     * @return list<Middleware>
     */
    public static function middleware(): array
    {
        return [
            new Middleware('permission:kelola-pengguna'),
        ];
    }

    public function index(Request $request): View
    {
        $filters = $request->validate([
            'search' => ['nullable', 'string', 'max:100'],
            'role' => ['nullable', Rule::in(array_keys(User::ROLE_LABELS))],
        ]);

        $users = User::with('roles')
            ->when($filters['search'] ?? null, function (Builder $query, string $search) {
                $query->where(function (Builder $q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                });
            })
            ->when($filters['role'] ?? null, fn (Builder $query, string $role) => $query->role($role))
            ->orderBy('name')
            ->paginate(10)
            ->withQueryString();

        return view('admin.users.index', [
            'users' => $users,
            'filters' => $filters,
            'roleLabels' => User::ROLE_LABELS,
        ]);
    }

    public function update(Request $request, User $user): RedirectResponse
    {
        $data = $request->validate([
            'role' => ['required', Rule::in(array_keys(User::ROLE_LABELS))],
        ]);

        if ($user->is($request->user())) {
            return redirect()->back(fallback: route('admin.users.index'))
                ->withErrors(['role' => 'Anda tidak dapat mengubah peran akun sendiri.']);
        }

        $user->syncRoles([$data['role']]);

        return redirect()->back(fallback: route('admin.users.index'))
            ->with('status', "Peran {$user->name} diubah menjadi ".User::ROLE_LABELS[$data['role']].'.');
    }
}
