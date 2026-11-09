@extends('adminlte::page')

@section('title', 'Input Nilai Proposal')

@section('content_header')
    @include('admin.partials.page-header', ['title' => 'Input Nilai Proposal'])
@endsection

@section('content')
    @include('admin.partials.flash')

    <div class="row">
        <div class="col-lg-8">
            <x-adminlte-card :title="$project->judul" icon="bi bi-journal-check" theme="primary" theme-mode="outline">
                <p class="text-body-secondary">
                    Diajukan oleh <strong>{{ $project->user->name }}</strong> &middot; Tema {{ $project->tema_agent }}
                </p>
                @if ($project->deskripsi)
                    <p>{{ $project->deskripsi }}</p>
                @endif

                <form method="POST" action="{{ route('admin.proposals.nilai.update', $project) }}">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="nilai" class="form-label">Nilai (0 - 100)</label>
                        <input type="number" id="nilai" name="nilai" step="0.01" min="0" max="100" required
                            value="{{ old('nilai', $project->nilai) }}"
                            class="form-control @error('nilai') is-invalid @enderror">
                        @error('nilai')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="catatan_review" class="form-label">Catatan Review</label>
                        <textarea id="catatan_review" name="catatan_review" rows="4"
                            class="form-control @error('catatan_review') is-invalid @enderror">{{ old('catatan_review', $project->catatan_review) }}</textarea>
                        @error('catatan_review')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Simpan Nilai</button>
                        <a href="{{ route('admin.proposals.index') }}" class="btn btn-outline-secondary">Kembali</a>
                    </div>
                </form>
            </x-adminlte-card>
        </div>
    </div>
@endsection
