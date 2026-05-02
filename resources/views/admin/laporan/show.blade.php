@extends('layouts.app')

@section('title', 'Detail Laporan Kerusakan')

@section('content')
<div class="row mb-4">
    <div class="col-12 d-flex justify-content-between align-items-center">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Detail Laporan Kerusakan</li>
            </ol>
        </nav>
        <a href="{{ route('admin.laporan.index') }}" class="btn btn-outline-secondary">
            <i class="bx bx-arrow-back me-1"></i> Kembali
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-7">
        <div class="card mb-4 shadow-sm">
            <div class="card-header border-bottom">
                <h5 class="mb-0 py-1 fw-bold">Informasi Laporan</h5>
            </div>
            <div class="card-body pt-4">
                <table class="table table-borderless mb-0">
                    <tr>
                        <td class="fw-semibold text-muted py-2" width="180">Tanggal Laporan</td>
                        <td class="py-2" width="10">:</td>
                        <td class="py-2">{{ \Carbon\Carbon::parse($laporan->tanggal_laporan)->translatedFormat('d F Y') }}</td>
                    </tr>
                    <tr>
                        <td class="fw-semibold text-muted py-2">Pelapor</td>
                        <td class="py-2">:</td>
                        <td class="py-2 text-capitalize">{{ $laporan->user?->nama ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td class="fw-semibold text-muted py-2">Inventaris</td>
                        <td class="py-2">:</td>
                        <td class="py-2">
                            {{ $laporan->inventaris?->nama_barang ?? '-' }}
                            <span class="text-muted small">({{ $laporan->inventaris?->kode_inventaris ?? '' }})</span>
                        </td>
                    </tr>
                    <tr>
                        <td class="fw-semibold text-muted py-2">Kecamatan</td>
                        <td class="py-2">:</td>
                        <td class="py-2">Kecamatan {{ $laporan->inventaris?->kecamatan?->nama_kecamatan ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td class="fw-semibold text-muted py-2">Status</td>
                        <td class="py-2">:</td>
                        <td class="py-2">
                            @if($laporan->status === 'menunggu')
                                <span class="badge bg-label-secondary">Menunggu</span>
                            @elseif($laporan->status === 'disetujui')
                                <span class="badge bg-label-info">Disetujui</span>
                            @elseif($laporan->status === 'ditolak')
                                <span class="badge bg-label-danger">Ditolak</span>
                            @elseif($laporan->status === 'diproses')
                                <span class="badge bg-label-warning">Diproses</span>
                            @else
                                <span class="badge bg-label-success">Selesai</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td class="fw-semibold text-muted py-2" style="vertical-align: top;">Deskripsi</td>
                        <td class="py-2" style="vertical-align: top;">:</td>
                        <td class="py-2">{{ $laporan->deskripsi_kerusakan }}</td>
                    </tr>
                </table>
            </div>
        </div>

        @if($laporan->foto)
        <div class="card mb-4 shadow-sm">
            <div class="card-header border-bottom">
                <h5 class="mb-0 py-1 fw-bold">Foto Kerusakan</h5>
            </div>
            <div class="card-body text-center pt-4">
                <img src="{{ asset('storage/' . $laporan->foto) }}" alt="Foto Kerusakan" class="img-fluid rounded border shadow-sm" style="max-height: 400px; width: 100%; object-fit: contain;">
            </div>
        </div>
        @endif
    </div>

    <div class="col-md-5">
        <div class="card mb-4 shadow-sm border-start border-warning border-3">
            <div class="card-header border-bottom">
                <h5 class="mb-0 py-1 fw-bold">Ubah Status</h5>
            </div>
            <div class="card-body pt-4">
                @if($laporan->status === 'disetujui')
                <form action="{{ route('admin.laporan.diproses', $laporan->id_laporan) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <button type="submit" class="btn btn-warning w-100 shadow-sm py-2">
                        <i class="bx bx-cog me-1"></i> Tandai Diproses
                    </button>
                </form>
                @elseif($laporan->status === 'diproses')
                <form action="{{ route('admin.laporan.selesai', $laporan->id_laporan) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <button type="submit" class="btn btn-success w-100 shadow-sm py-2">
                        <i class="bx bx-check-double me-1"></i> Selesaikan Perbaikan
                    </button>
                </form>
                @elseif($laporan->status === 'selesai')
                <div class="alert alert-success d-flex align-items-center mb-0" role="alert">
                    <i class="bx bx-check-circle me-2 fs-4"></i>
                    <div>Laporan telah selesai ditangani.</div>
                </div>
                @elseif($laporan->status === 'ditolak')
                <div class="alert alert-danger d-flex align-items-center mb-0" role="alert">
                    <i class="bx bx-x-circle me-2 fs-4"></i>
                    <div>Laporan ini telah ditolak oleh Kabid.</div>
                </div>
                @endif
            </div>
        </div>

        <div class="card shadow-sm">
            <div class="card-header border-bottom">
                <h5 class="mb-0 py-1 fw-bold">Catatan Perbaikan</h5>
            </div>
            <div class="card-body pt-4">
                <div class="timeline-container mb-4" style="max-height: 300px; overflow-y: auto;">
                    @forelse($laporan->catatan as $catatan)
                    <div class="mb-3 p-3 bg-light rounded border">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="fw-bold text-primary">{{ $catatan->user?->nama ?? 'Admin' }}</span>
                            <small class="text-muted">{{ \Carbon\Carbon::parse($catatan->tanggal)->format('d/m/Y') }}</small>
                        </div>
                        <p class="mb-0 small text-dark">{{ $catatan->catatan }}</p>
                    </div>
                    @empty
                    <div class="text-center py-3 text-muted">
                        <i class="bx bx-note fs-1 d-block mb-2"></i>
                        <p class="mb-0">Belum ada catatan perbaikan.</p>
                    </div>
                    @endforelse
                </div>

                @if($laporan->status !== 'ditolak')
                <hr class="my-4">

                <form action="{{ route('admin.catatan.store') }}" method="POST" novalidate id="formCatatan">
                    @csrf
                    <input type="hidden" name="id_laporan" value="{{ $laporan->id_laporan }}">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Catatan <span class="text-danger">*</span></label>
                        <textarea name="catatan" class="form-control @error('catatan') is-invalid @enderror" rows="3" placeholder="Apa yang telah diperbaiki?" required>{{ old('catatan') }}</textarea>
                        <div class="invalid-feedback">Catatan wajib diisi.</div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Tanggal <span class="text-danger">*</span></label>
                        <input type="date" name="tanggal" class="form-control @error('tanggal') is-invalid @enderror" value="{{ old('tanggal', date('Y-m-d')) }}" required />
                        <div class="invalid-feedback">Tanggal wajib diisi.</div>
                    </div>
                    <button type="submit" class="btn btn-primary w-100 py-2">
                        <i class="bx bx-send me-1"></i> Simpan Catatan
                    </button>
                </form>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
