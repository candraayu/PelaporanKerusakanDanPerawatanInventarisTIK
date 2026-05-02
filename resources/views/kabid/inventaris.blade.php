@extends('layouts.app')

@section('title', 'Monitoring Inventaris')

@section('content')
<div class="row mb-4">
    <div class="col-12 d-flex justify-content-between align-items-center">
        <h4 class="fw-bold py-3 mb-0">Monitoring Inventaris</h4>
        <form action="{{ route('kabid.inventaris.index') }}" method="GET" class="d-flex gap-2">
            <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="Cari nama barang..." value="{{ request('search') }}">
                <button class="btn btn-primary" type="submit">
                    <i class="bx bx-search"></i>
                </button>
                @if(request('search'))
                    <a href="{{ route('kabid.inventaris.index') }}" class="btn btn-outline-secondary">
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
                    <th>Kode</th>
                    <th>Nama Barang</th>
                    <th>Kategori</th>
                    <th>Kondisi</th>
                    <th>Kecamatan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody class="table-border-bottom-0">
                @forelse ($inventaris as $index => $item)
                <tr>
                    <td>{{ $inventaris->firstItem() + $index }}</td>
                    <td><strong>{{ $item->kode_inventaris }}</strong></td>
                    <td>
                        <i class="bx bx-cube text-primary me-2"></i>
                        {{ $item->nama_barang }}
                    </td>
                    <td>{{ $item->kategori }}</td>
                    <td>
                        @if($item->kondisi === 'baik')
                            <span class="badge bg-label-success">Baik</span>
                        @elseif($item->kondisi === 'rusak ringan')
                            <span class="badge bg-label-warning">Rusak Ringan</span>
                        @else
                            <span class="badge bg-label-danger">Rusak Berat</span>
                        @endif
                    </td>
                    <td>{{ $item->kecamatan?->nama_kecamatan ?? '-' }}</td>
                    <td>
                        <button type="button" class="btn btn-sm btn-icon btn-outline-info" data-bs-toggle="modal" data-bs-target="#modalDetail{{ $item->id_inventaris }}" title="Detail">
                            <i class="bx bx-show"></i>
                        </button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center">Data inventaris tidak ditemukan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($inventaris->hasPages())
    <div class="card-footer d-flex justify-content-end">
        {{ $inventaris->appends(['search' => request('search')])->links('pagination::bootstrap-5') }}
    </div>
    @endif
</div>

@foreach ($inventaris as $item)
<div class="modal fade" id="modalDetail{{ $item->id_inventaris }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Inventaris</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <small class="text-muted d-block">Kode Inventaris</small>
                        <p class="fw-bold text-primary fs-5 mb-0">{{ $item->kode_inventaris }}</p>
                    </div>
                    <div class="col-md-6 text-md-end">
                        <small class="text-muted d-block">Status Kondisi</small>
                        <span class="badge {{ $item->kondisi === 'baik' ? 'bg-success' : ($item->kondisi === 'rusak ringan' ? 'bg-warning' : 'bg-danger') }}">
                            {{ ucfirst($item->kondisi) }}
                        </span>
                    </div>

                    <div class="col-12 border-top pt-3">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <small class="text-muted d-block">Nama Barang</small>
                                <p class="fw-bold mb-0">{{ $item->nama_barang }}</p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <small class="text-muted d-block">Kategori</small>
                                <p class="fw-bold mb-0">{{ $item->kategori }}</p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <small class="text-muted d-block">Merk / Tipe</small>
                                <p class="fw-bold mb-0">{{ $item->merk ?? '-' }} {{ $item->tipe ? '/ ' . $item->tipe : '' }}</p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <small class="text-muted d-block">Tahun Pengadaan</small>
                                <p class="fw-bold mb-0">{{ $item->tahun_pengadaan ?? '-' }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 border-top pt-3">
                        <div class="card bg-label-secondary border-0 shadow-none">
                            <div class="card-body p-3">
                                <div class="d-flex align-items-center">
                                    <div class="avatar avatar-sm me-3">
                                        <span class="avatar-initial rounded bg-primary"><i class="bx bx-map"></i></span>
                                    </div>
                                    <div>
                                        <small class="text-muted d-block">Lokasi Kecamatan</small>
                                        <p class="fw-bold mb-0">{{ $item->kecamatan?->nama_kecamatan ?? 'Tidak Terdefinisi' }}</p>
                                    </div>
                                </div>
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
