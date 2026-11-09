@extends('adminlte::page')

@section('title', 'Dashboard Admin')

@section('content_header')
    @include('admin.partials.page-header', [
        'title' => 'Dashboard',
        'subtitle' => 'Ringkasan data Secure Academic Portal secara real-time',
    ])
@endsection

@section('content')
    @include('admin.partials.flash')

    {{-- Widget statistik agregat: setiap angka berasal dari kueri model count(). --}}
    <div class="row">
        <div class="col-lg-3 col-6">
            <x-adminlte-small-box :title="number_format($stats['mahasiswa'])" text="Total Mahasiswa"
                icon="bi bi-mortarboard-fill" theme="primary"
                :url="route('admin.mahasiswa.index')" url-text="Lihat data mahasiswa" />
        </div>
        <div class="col-lg-3 col-6">
            <x-adminlte-small-box :title="number_format($stats['pengajar'])" text="Admin & Staf Pengajar"
                icon="bi bi-person-workspace" theme="success"
                :url="$user->can('kelola-pengguna') ? route('admin.users.index') : null"
                url-text="Kelola peran pengguna" />
        </div>
        <div class="col-lg-3 col-6">
            <x-adminlte-small-box :title="number_format($stats['proposal'])" text="Total Proposal"
                icon="bi bi-journal-text" theme="warning"
                :url="route('admin.proposals.index')" url-text="Lihat semua proposal" />
        </div>
        <div class="col-lg-3 col-6">
            <x-adminlte-small-box :title="number_format($stats['belumDinilai'])" text="Proposal Belum Dinilai"
                icon="bi bi-hourglass-split" theme="danger"
                :url="route('admin.proposals.index', ['status' => 'belum'])" url-text="Nilai sekarang" />
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <x-adminlte-card title="Proposal Terbaru" icon="bi bi-clock-history" theme="primary" theme-mode="outline"
                body-class="p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead>
                            <tr>
                                <th>Judul</th>
                                <th>Pengusul</th>
                                <th>Tema</th>
                                <th class="text-end">Nilai</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($latestProposals as $project)
                                <tr>
                                    <td>{{ $project->judul }}</td>
                                    <td>{{ $project->user->name }}</td>
                                    <td><span class="badge text-bg-secondary">{{ $project->tema_agent }}</span></td>
                                    <td class="text-end">
                                        @if ($project->nilai === null)
                                            <span class="badge text-bg-warning">Belum dinilai</span>
                                        @else
                                            <span class="badge text-bg-success">{{ $project->nilai }}</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-body-secondary py-4">Belum ada proposal.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </x-adminlte-card>

            <x-adminlte-card title="Distribusi Tema Agent" icon="bi bi-bar-chart-line" theme="warning" theme-mode="outline">
                @forelse ($temaSummary as $tema)
                    @php($persen = $stats['proposal'] > 0 ? round($tema->total / $stats['proposal'] * 100) : 0)
                    <div class="mb-3">
                        <div class="d-flex justify-content-between">
                            <span>{{ $tema->tema_agent }}</span>
                            <span class="text-body-secondary">{{ $tema->total }} proposal ({{ $persen }}%)</span>
                        </div>
                        <div class="progress" role="progressbar" aria-label="{{ $tema->tema_agent }}"
                            aria-valuenow="{{ $persen }}" aria-valuemin="0" aria-valuemax="100" style="height: 8px">
                            <div class="progress-bar bg-warning" style="width: {{ $persen }}%"></div>
                        </div>
                    </div>
                @empty
                    <p class="text-body-secondary mb-0">Belum ada data tema.</p>
                @endforelse
            </x-adminlte-card>
        </div>

        <div class="col-lg-4">
            <x-adminlte-card title="Hak Akses Anda" icon="bi bi-shield-check" theme="success" theme-mode="outline">
                <p class="mb-2">
                    <strong>{{ $user->name }}</strong><br>
                    <span class="text-body-secondary">Peran Spatie:</span>
                    <span class="badge {{ $user->hasRole(\App\Models\User::ROLE_ADMIN) ? 'text-bg-danger' : 'text-bg-info' }}">
                        {{ $user->roleName() }}
                    </span>
                </p>
                <ul class="list-group list-group-flush">
                    @foreach ($permissions as $permission)
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                            <code>{{ $permission }}</code>
                            @can($permission)
                                <span class="text-success"><i class="bi bi-check-circle-fill"></i> Diizinkan</span>
                            @else
                                <span class="text-body-secondary"><i class="bi bi-x-circle"></i> Tidak</span>
                            @endcan
                        </li>
                    @endforeach
                </ul>
                <p class="small text-body-secondary mt-3 mb-0">
                    Izin dibaca dinamis dari tabel <code>roles</code>, <code>permissions</code>, dan
                    <code>role_has_permissions</code>.
                </p>
            </x-adminlte-card>

            @role('admin')
                <x-adminlte-callout theme="danger" title="Mode Admin">
                    Anda memegang akses penuh: menghapus data dan mengubah peran pengguna.
                </x-adminlte-callout>
            @else
                <x-adminlte-callout theme="info" title="Mode Staf">
                    Anda dapat melihat data dan mengisi nilai proposal. Penghapusan data khusus Admin.
                </x-adminlte-callout>
            @endrole
        </div>
    </div>
@endsection
