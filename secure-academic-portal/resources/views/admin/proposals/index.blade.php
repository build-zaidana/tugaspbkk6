@extends('adminlte::page')

@section('title', 'Proposal & Nilai')

@section('content_header')
    @include('admin.partials.page-header', [
        'title' => 'Proposal & Nilai',
        'subtitle' => 'Tinjau, nilai, dan kelola proposal proyek Agentic AI mahasiswa',
    ])
@endsection

@section('content')
    @include('admin.partials.flash')

    <x-adminlte-card title="Filter Proposal" icon="bi bi-funnel" theme="primary" theme-mode="outline">
        <form method="GET" action="{{ route('admin.proposals.index') }}" class="row g-2 align-items-end">
            <div class="col-md-5">
                <label for="search" class="form-label">Kata kunci</label>
                <input type="search" id="search" name="search" value="{{ $filters['search'] ?? '' }}"
                    class="form-control" placeholder="Judul proposal atau nama pengusul">
            </div>
            <div class="col-md-3">
                <label for="tema" class="form-label">Tema agent</label>
                <select id="tema" name="tema" class="form-select">
                    <option value="">Semua tema</option>
                    @foreach ($temaOptions as $tema)
                        <option value="{{ $tema }}" @selected($tema === ($filters['tema'] ?? null))>{{ $tema }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <label for="status" class="form-label">Status nilai</label>
                <select id="status" name="status" class="form-select">
                    <option value="">Semua status</option>
                    <option value="belum" @selected(($filters['status'] ?? null) === 'belum')>Belum dinilai</option>
                    <option value="dinilai" @selected(($filters['status'] ?? null) === 'dinilai')>Sudah dinilai</option>
                </select>
            </div>
            <div class="col-md-2 d-flex gap-2">
                <button type="submit" class="btn btn-primary flex-fill"><i class="bi bi-search"></i> Cari</button>
                <a href="{{ route('admin.proposals.index') }}" class="btn btn-outline-secondary" title="Reset filter">
                    <i class="bi bi-arrow-counterclockwise"></i>
                </a>
            </div>
        </form>
    </x-adminlte-card>

    <x-adminlte-card title="Daftar Proposal" icon="bi bi-journal-text" body-class="p-0">
        <div class="table-responsive">
            <table class="table table-striped table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th>Judul</th>
                        <th>Pengusul</th>
                        <th>Tema</th>
                        <th class="text-center">Nilai</th>
                        <th class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($projects as $project)
                        <tr>
                            <td>
                                <div class="fw-semibold">{{ $project->judul }}</div>
                                <small class="text-body-secondary">{{ \Illuminate\Support\Str::limit($project->deskripsi, 90) }}</small>
                            </td>
                            <td>{{ $project->user->name }}</td>
                            <td><span class="badge text-bg-secondary">{{ $project->tema_agent }}</span></td>
                            <td class="text-center">
                                @if ($project->nilai === null)
                                    <span class="badge text-bg-warning">Belum dinilai</span>
                                @else
                                    <span class="badge text-bg-success">{{ $project->nilai }}</span>
                                @endif
                            </td>
                            <td class="text-end text-nowrap">
                                @can('kelola-nilai')
                                    <a href="{{ route('admin.proposals.nilai.edit', $project) }}" class="btn btn-sm btn-primary">
                                        <i class="bi bi-pencil-square"></i> Input Nilai
                                    </a>
                                @endcan
                                {{-- Tombol hapus hanya dirender untuk pemegang izin hapus-data (admin). --}}
                                @can('hapus-data')
                                    <form method="POST" action="{{ route('admin.proposals.destroy', $project) }}" class="d-inline"
                                        onsubmit="return confirm('Hapus proposal ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            <i class="bi bi-trash"></i> Hapus Data
                                        </button>
                                    </form>
                                @endcan
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-body-secondary py-4">
                                Tidak ada proposal yang cocok dengan filter.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <x-slot name="footerSlot">
            {{ $projects->links('admin.partials.pagination') }}
        </x-slot>
    </x-adminlte-card>
@endsection
