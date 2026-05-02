@extends('layouts.app')

@section('title', 'Rekap Laporan Kerusakan')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <h4 class="fw-bold py-3 mb-0">Rekap Laporan Kerusakan</h4>
    </div>
</div>

<!-- Filter Box -->
<div class="card mb-4 shadow-sm">
    <div class="card-header border-bottom">
        <h5 class="mb-0 fw-bold"><i class="bx bx-filter-alt me-1"></i> Filter Periode</h5>
    </div>
    <div class="card-body pt-4">
        <form action="{{ route('operator.rekap.index') }}" method="GET">
            <div class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label class="form-label fw-bold">Tanggal Awal</label>
                    <input type="date" name="tanggal_awal" class="form-control" value="{{ request('tanggal_awal') }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-bold">Tanggal Akhir</label>
                    <input type="date" name="tanggal_akhir" class="form-control" value="{{ request('tanggal_akhir') }}">
                </div>
                <div class="col-md-4 d-flex gap-2">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bx bx-search me-1"></i> Tampilkan
                    </button>
                    <a href="{{ route('operator.rekap.index') }}" class="btn btn-outline-secondary w-100">
                        <i class="bx bx-refresh me-1"></i> Reset
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Data Table -->
<div class="card shadow-sm">
    <div class="card-header d-flex justify-content-between align-items-center border-bottom">
        <h5 class="mb-0 fw-bold">Hasil Rekapitulasi</h5>
        @if($laporan->count() > 0)
        <form action="{{ route('operator.rekap.download') }}" method="GET" target="_blank">
            <input type="hidden" name="tanggal_awal" value="{{ request('tanggal_awal') }}">
            <input type="hidden" name="tanggal_akhir" value="{{ request('tanggal_akhir') }}">
            <button type="submit" class="btn btn-danger shadow-sm">
                <i class="bx bxs-file-pdf me-1"></i> Download PDF
            </button>
        </form>
        @endif
    </div>
    <div class="table-responsive text-nowrap">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th width="50">No</th>
                    <th>Tanggal</th>
                    <th>Barang / Kode</th>
                    <th>Deskripsi Kerusakan</th>
                    <th class="text-center">Status</th>
                </tr>
            </thead>
            <tbody class="table-border-bottom-0">
                @forelse($laporan as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ \Carbon\Carbon::parse($item->tanggal_laporan)->format('d/m/Y') }}</td>
                    <td>
                        <span class="fw-bold">{{ $item->inventaris?->nama_barang }}</span><br>
                        <small class="text-muted">{{ $item->inventaris?->kode_inventaris }}</small>
                    </td>
                    <td>
                        <span class="d-inline-block text-truncate" style="max-width: 300px;">
                            {{ $item->deskripsi_kerusakan }}
                        </span>
                    </td>
                    <td class="text-center">
                        @php
                            $badge = [
                                'menunggu' => 'bg-label-warning',
                                'diproses' => 'bg-label-info',
                                'selesai'  => 'bg-label-success',
                                'ditolak'  => 'bg-label-danger'
                            ][$item->status] ?? 'bg-label-secondary';
                        @endphp
                        <span class="badge {{ $badge }} text-capitalize">{{ $item->status }}</span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center py-5 text-muted">
                        <i class="bx bx-info-circle fs-2 d-block mb-2"></i>
                        Tidak ada data ditemukan untuk periode ini.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
