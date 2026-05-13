@extends('layouts.app')

@section('title', 'Data Perawatan')

@section('content')
<div class="row mb-4">
    <div class="col-12 d-flex justify-content-between align-items-center">
        <h4 class="fw-bold py-3 mb-0">Data Perawatan</h4>

        <form action="{{ route('admin.perawatan.index') }}" method="GET" class="d-flex gap-2">
            <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="Cari perawatan/kecamatan..." value="{{ request('search') }}">
                <button class="btn btn-primary" type="submit">
                    <i class="bx bx-search"></i>
                </button>
                @if(request('search'))
                    <a href="{{ route('admin.perawatan.index') }}" class="btn btn-outline-secondary">
                        <i class="bx bx-x"></i>
                    </a>
                @endif
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="table-responsive text-nowrap">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th width="70">No</th>
                    <th>Kecamatan</th>
                    <th>Inventaris</th>
                    <th>Tanggal</th>
                    <th>Jenis</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody class="table-border-bottom-0">
                @forelse ($perawatan as $index => $item)
                <tr>
                    <td>{{ $perawatan->firstItem() + $index }}</td>

                    {{-- Kecamatan --}}
                    <td>
                        <span class="badge bg-label-secondary">
                            {{ $item->inventaris->kecamatan->nama_kecamatan ?? '-' }}
                        </span>
                    </td>

                    {{-- Inventaris --}}
                    <td>
                        <div class="d-flex align-items-center">
                            <div class="avatar avatar-xs me-2">
                                <span class="avatar-initial rounded bg-label-primary">
                                    <i class="bx bx-cog"></i>
                                </span>
                            </div>
                            <div>
                                <span class="fw-bold">{{ $item->inventaris->nama_barang ?? '-' }}</span><br>
                                <small class="text-muted">{{ $item->inventaris->kode_inventaris ?? '-' }}</small>
                            </div>
                        </div>
                    </td>

                    {{-- Tanggal --}}
                    <td>
                        {{ \Carbon\Carbon::parse($item->tanggal_perawatan)->translatedFormat('d M Y') }}
                    </td>

                    {{-- Jenis --}}
                    <td>
                        <span class="badge 
                            @if($item->jenis_perawatan == 'Rutin') bg-label-success
                            @elseif($item->jenis_perawatan == 'Perbaikan') bg-label-warning
                            @else bg-label-info
                            @endif">
                            {{ $item->jenis_perawatan }}
                        </span>
                    </td>

                    {{-- Aksi --}}
                    <td>
                        <button type="button"
                            class="btn btn-sm btn-icon btn-outline-info"
                            data-bs-toggle="modal"
                            data-bs-target="#modalDetail{{ $item->id_perawatan }}">
                            <i class="bx bx-info-circle"></i>
                        </button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center">Data perawatan tidak ditemukan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($perawatan->hasPages())
    <div class="card-footer d-flex justify-content-end">
        {{ $perawatan->appends(['search' => request('search')])->links('pagination::bootstrap-5') }}
    </div>
    @endif
</div>

{{-- MODAL DETAIL --}}
@foreach ($perawatan as $item)
<div class="modal fade" id="modalDetail{{ $item->id_perawatan }}" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Detail Perawatan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <div class="row g-3">

                    <div class="col-md-6">
                        <label class="form-label text-muted">Kecamatan</label>
                        <p class="fw-bold mb-0">
                            {{ $item->inventaris->kecamatan->nama_kecamatan ?? '-' }}
                        </p>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label text-muted">Inventaris</label>
                        <p class="fw-bold mb-0">{{ $item->inventaris->nama_barang ?? '-' }}</p>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label text-muted">Kode</label>
                        <p class="fw-bold mb-0">{{ $item->inventaris->kode_inventaris ?? '-' }}</p>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label text-muted">Tanggal Perawatan</label>
                        <p class="fw-bold mb-0">
                            {{ \Carbon\Carbon::parse($item->tanggal_perawatan)->translatedFormat('d F Y') }}
                        </p>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label text-muted">Jenis Perawatan</label>
                        <p class="fw-bold mb-0">{{ $item->jenis_perawatan }}</p>
                    </div>

                    <div class="col-12">
                        <label class="form-label text-muted">Keterangan</label>
                        <p class="mb-0">{{ $item->keterangan ?? '-' }}</p>
                    </div>

                    <div class="col-12 border-top pt-3">
                        <div class="d-flex justify-content-between">
                            <div>
                                <label class="form-label text-muted small">Tanggal Input</label>
                                <p class="mb-0 small">
                                    {{ $item->created_at ? $item->created_at->translatedFormat('d M Y') : '-' }}
                                </p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <div class="modal-footer">
                <button class="btn btn-outline-secondary w-100" data-bs-dismiss="modal">
                    Tutup
                </button>
            </div>

        </div>
    </div>
</div>
@endforeach

@endsection