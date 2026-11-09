@extends('adminlte::page')

@section('title', 'Data Mahasiswa')

@section('content_header')
    @include('admin.partials.page-header', [
        'title' => 'Data Mahasiswa',
        'subtitle' => 'Cari berdasarkan nama, NRP, atau email dan saring per departemen',
    ])
@endsection

@section('content')
    @include('admin.partials.flash')

    <x-adminlte-card title="Filter Pencarian" icon="bi bi-funnel" theme="primary" theme-mode="outline">
        <form method="GET" action="{{ route('admin.mahasiswa.index') }}" class="row g-2 align-items-end">
            <div class="col-md-6">
                <label for="search" class="form-label">Kata kunci</label>
                <input type="search" id="search" name="search" value="{{ $search }}" class="form-control"
                    placeholder="Nama, NRP, atau email">
            </div>
            <div class="col-md-4">
                <label for="department" class="form-label">Departemen</label>
                <select id="department" name="department" class="form-select">
                    <option value="">Semua departemen</option>
                    @foreach ($departments as $option)
                        <option value="{{ $option }}" @selected($option === $department)>{{ $option }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2 d-flex gap-2">
                <button type="submit" class="btn btn-primary flex-fill"><i class="bi bi-search"></i> Cari</button>
                <a href="{{ route('admin.mahasiswa.index') }}" class="btn btn-outline-secondary" title="Reset filter">
                    <i class="bi bi-arrow-counterclockwise"></i>
                </a>
            </div>
        </form>
    </x-adminlte-card>

    <x-adminlte-card title="Daftar Mahasiswa" icon="bi bi-mortarboard" body-class="p-0">
        <div class="table-responsive">
            <table class="table table-striped table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th style="width: 3rem">#</th>
                        <th>Nama</th>
                        <th>NRP</th>
                        <th>Departemen</th>
                        <th>Email</th>
                        <th class="text-center">Proposal</th>
                        @can('hapus-data')
                            <th class="text-end">Aksi</th>
                        @endcan
                    </tr>
                </thead>
                <tbody>
                    @forelse ($mahasiswas as $mahasiswa)
                        <tr>
                            <td>{{ $mahasiswas->firstItem() + $loop->index }}</td>
                            <td class="fw-semibold">{{ $mahasiswa->name }}</td>
                            <td>{{ $mahasiswa->nrp ?? '-' }}</td>
                            <td>{{ $mahasiswa->department }}</td>
                            <td>{{ $mahasiswa->email }}</td>
                            <td class="text-center"><span class="badge text-bg-primary">{{ $mahasiswa->projects_count }}</span></td>
                            {{-- Tombol hapus hanya dirender untuk pemegang izin hapus-data (admin). --}}
                            @can('hapus-data')
                                <td class="text-end">
                                    <form method="POST" action="{{ route('admin.mahasiswa.destroy', $mahasiswa) }}"
                                        onsubmit="return confirm('Hapus mahasiswa ini beserta seluruh proposalnya?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            <i class="bi bi-trash"></i> Hapus Data
                                        </button>
                                    </form>
                                </td>
                            @endcan
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-body-secondary py-4">
                                Tidak ada mahasiswa yang cocok dengan filter.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <x-slot name="footerSlot">
            {{ $mahasiswas->links('admin.partials.pagination') }}
        </x-slot>
    </x-adminlte-card>
@endsection
