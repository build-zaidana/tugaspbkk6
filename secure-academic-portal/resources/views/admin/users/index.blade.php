@extends('adminlte::page')

@section('title', 'Kelola Peran Pengguna')

@section('content_header')
    @include('admin.partials.page-header', [
        'title' => 'Kelola Peran Pengguna',
        'subtitle' => 'Ubah peran Spatie setiap akun secara dinamis tanpa menyentuh kode',
    ])
@endsection

@section('content')
    @include('admin.partials.flash')

    <x-adminlte-card title="Filter Pengguna" icon="bi bi-funnel" theme="primary" theme-mode="outline">
        <form method="GET" action="{{ route('admin.users.index') }}" class="row g-2 align-items-end">
            <div class="col-md-6">
                <label for="search" class="form-label">Kata kunci</label>
                <input type="search" id="search" name="search" value="{{ $filters['search'] ?? '' }}"
                    class="form-control" placeholder="Nama atau email">
            </div>
            <div class="col-md-4">
                <label for="role" class="form-label">Peran</label>
                <select id="role" name="role" class="form-select">
                    <option value="">Semua peran</option>
                    @foreach ($roleLabels as $role => $label)
                        <option value="{{ $role }}" @selected($role === ($filters['role'] ?? null))>{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2 d-flex gap-2">
                <button type="submit" class="btn btn-primary flex-fill"><i class="bi bi-search"></i> Cari</button>
                <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary" title="Reset filter">
                    <i class="bi bi-arrow-counterclockwise"></i>
                </a>
            </div>
        </form>
    </x-adminlte-card>

    <x-adminlte-card title="Daftar Pengguna" icon="bi bi-people" body-class="p-0">
        <div class="table-responsive">
            <table class="table table-striped table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Peran Saat Ini</th>
                        <th style="min-width: 18rem">Ubah Peran</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $account)
                        <tr>
                            <td class="fw-semibold">{{ $account->name }}</td>
                            <td>{{ $account->email }}</td>
                            <td>
                                <span @class([
                                    'badge',
                                    'text-bg-danger' => $account->roleName() === \App\Models\User::ROLE_ADMIN,
                                    'text-bg-info' => $account->roleName() === \App\Models\User::ROLE_STAF,
                                    'text-bg-secondary' => $account->roleName() === \App\Models\User::ROLE_MAHASISWA,
                                ])>{{ $account->roleLabel() }}</span>
                            </td>
                            <td>
                                @if ($account->is(auth()->user()))
                                    <small class="text-body-secondary">Akun Anda sendiri</small>
                                @else
                                    <form method="POST" action="{{ route('admin.users.role.update', $account) }}" class="d-flex gap-2">
                                        @csrf
                                        @method('PUT')
                                        <select name="role" class="form-select form-select-sm" aria-label="Peran baru {{ $account->name }}">
                                            @foreach ($roleLabels as $role => $label)
                                                <option value="{{ $role }}" @selected($role === $account->roleName())>{{ $label }}</option>
                                            @endforeach
                                        </select>
                                        <button type="submit" class="btn btn-sm btn-outline-primary">Simpan</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-body-secondary py-4">Tidak ada pengguna yang cocok.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <x-slot name="footerSlot">
            {{ $users->links('admin.partials.pagination') }}
        </x-slot>
    </x-adminlte-card>
@endsection
