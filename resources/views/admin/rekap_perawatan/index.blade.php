@extends('layouts.app')

@section('title', 'Rekap Perawatan')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <h4 class="fw-bold py-3 mb-0">Rekap Perawatan</h4>
    </div>
</div>

<!-- FILTER -->
<div class="card mb-4 shadow-sm">
    <div class="card-header border-bottom">
        <h5 class="mb-0 fw-bold">
            <i class="bx bx-filter-alt me-1"></i> Filter Periode
        </h5>
    </div>
    <div class="card-body">
        <form method="GET">
            <div class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label class="form-label fw-bold">Tanggal Awal</label>
                    <input type="date" name="tanggal_awal" class="form-control"
                        value="{{ request('tanggal_awal') }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-bold">Tanggal Akhir</label>
                    <input type="date" name="tanggal_akhir" class="form-control"
                        value="{{ request('tanggal_akhir') }}">
                </div>
                <div class="col-md-4 d-flex gap-2">
                    <button class="btn btn-primary w-100">
                        <i class="bx bx-search me-1"></i> Tampilkan
                    </button>
                    <a href="" class="btn btn-outline-secondary w-100">
                        Reset
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- TABEL -->
<div class="card shadow-sm">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="fw-bold">Data Perawatan</h5>

        @if($data->count() > 0)
        <form action="{{ route('admin.rekap_perawatan.download') }}" method="GET" target="_blank">
            <input type="hidden" name="tanggal_awal" value="{{ request('tanggal_awal') }}">
            <input type="hidden" name="tanggal_akhir" value="{{ request('tanggal_akhir') }}">
            <button class="btn btn-danger">
                <i class="bx bxs-file-pdf me-1"></i> Download PDF
            </button>
        </form>
        @endif
    </div>

    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>Kecamatan</th>
                    <th>Barang</th>
                    <th>Jenis Perawatan</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @forelse($data as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ \Carbon\Carbon::parse($item->tanggal_perawatan)->format('d/m/Y') }}</td>
                     <td>
                        {{ $item->inventaris->kecamatan->nama_kecamatan ?? '-' }}
                    </td>
                    <td>
                        <strong>{{ $item->inventaris->nama_barang }}</strong><br>
                        <small>{{ $item->inventaris->kode_inventaris }}</small>
                    </td>
                    <td>
                        <span class="badge bg-label-info">
                            {{ $item->jenis_perawatan }}
                        </span>
                    </td>
                    <td>{{ $item->keterangan ?? '-' }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center text-muted py-4">
                        Tidak ada data perawatan.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection