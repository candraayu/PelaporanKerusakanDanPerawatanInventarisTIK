@extends('layouts.app')

@section('title', 'Monitoring Kecamatan')

@section('content')
<div class="row mb-4">
    <div class="col-12 d-flex justify-content-between align-items-center">
        <h4 class="fw-bold py-3 mb-0">Monitoring Kecamatan</h4>
        <form action="{{ route('kabid.kecamatan.index') }}" method="GET" class="d-flex gap-2">
            <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="Cari kecamatan..." value="{{ request('search') }}">
                <button class="btn btn-primary" type="submit">
                    <i class="bx bx-search"></i>
                </button>
                @if(request('search'))
                    <a href="{{ route('kabid.kecamatan.index') }}" class="btn btn-outline-secondary">
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
                    <th>Kode Kemendagri</th>
                    <th>Nama Kecamatan</th>
                    <th>Kontak</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody class="table-border-bottom-0">
                @forelse ($kecamatan as $index => $item)
                <tr>
                    <td>{{ $kecamatan->firstItem() + $index }}</td>
                    <td><span class="badge bg-label-secondary fw-bold">{{ $item->kode_kecamatan }}</span></td>
                    <td>
                        <div class="d-flex align-items-center">
                            <div class="avatar avatar-xs me-2">
                                <span class="avatar-initial rounded bg-label-primary"><i class="bx bx-map"></i></span>
                            </div>
                            <span class="fw-bold">{{ $item->nama_kecamatan }}</span>
                        </div>
                    </td>
                    <td>{{ $item->kontak ?? '-' }}</td>
                    <td>
                        <button type="button" class="btn btn-sm btn-icon btn-outline-info" data-bs-toggle="modal" data-bs-target="#modalDetail{{ $item->id_kecamatan }}" title="Detail">
                            <i class="bx bx-info-circle"></i>
                        </button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center">Data kecamatan tidak ditemukan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($kecamatan->hasPages())
    <div class="card-footer d-flex justify-content-end">
        {{ $kecamatan->appends(['search' => request('search')])->links('pagination::bootstrap-5') }}
    </div>
    @endif
</div>

@foreach ($kecamatan as $item)
<div class="modal fade" id="modalDetail{{ $item->id_kecamatan }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Data Kecamatan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label text-muted">Kode Kecamatan</label>
                        <p class="fw-bold mb-0">{{ $item->kode_kecamatan }}</p>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label text-muted">Nama Kecamatan</label>
                        <p class="fw-bold mb-0">{{ $item->nama_kecamatan }}</p>
                    </div>
                    <div class="col-12 border-top pt-3">
                        <label class="form-label text-muted">Alamat</label>
                        <p class="mb-0">{{ $item->alamat ?? 'Alamat belum diatur.' }}</p>
                    </div>
                    <div class="col-12">
                        <label class="form-label text-muted">Kontak / Telepon</label>
                        <p class="fw-bold mb-0 text-primary">{{ $item->kontak ?? '-' }}</p>
                    </div>
                    <div class="col-12 border-top pt-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <label class="form-label text-muted d-block small">Total Inventaris</label>
                                <span class="badge bg-label-info">{{ $item->inventaris_count ?? $item->inventaris()->count() }} Barang</span>
                            </div>
                            <div class="text-end">
                                <label class="form-label text-muted d-block small">Tgl Registrasi</label>
                                <span class="fw-medium small">{{ $item->created_at ? $item->created_at->translatedFormat('d F Y') : '-' }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary w-100" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
@endforeach

@endsection
