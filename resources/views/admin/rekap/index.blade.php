@extends('layouts.app')

@section('title', 'Rekap Laporan Kerusakan')

@section('content')
<div class="row mb-4">
    <div class="col-12 d-flex flex-wrap justify-content-between align-items-center gap-3">
        <h4 class="fw-bold py-3 mb-0">Rekap Laporan Kerusakan</h4>

        <div class="d-flex align-items-center gap-2">
            <form action="{{ route('admin.rekap.index') }}" method="GET" class="d-flex">
                <div class="input-group">
                    <input type="text" name="search" class="form-control" placeholder="Cari barang/pelapor..." value="{{ request('search') }}">
                    <button type="submit" class="btn btn-outline-primary"><i class="bx bx-search"></i></button>
                </div>
            </form>

            <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#modalFilter">
                <i class="bx bx-filter-alt me-1"></i> Filter
            </button>

            <a href="{{ route('admin.rekap.download', request()->query()) }}" target="_blank" class="btn btn-danger">
                <i class="bx bx-file me-1"></i> Cetak PDF
            </a>
        </div>
    </div>
</div>

<div class="card">
    <div class="table-responsive text-nowrap">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Pelapor</th>
                    <th>Barang</th>
                    <th>Deskripsi Kerusakan</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody class="table-border-bottom-0">
                @forelse ($laporan as $item)
                <tr>
                    <td>{{ $item->created_at->format('d/m/Y') }}</td>
                    <td>{{ $item->user->nama }}</td>
                    <td>
                        <strong>{{ $item->inventaris->kode_inventaris }}</strong><br>
                        <small>{{ $item->inventaris->nama_barang }}</small>
                    </td>
                    <td>{{ Str::limit($item->deskripsi_kerusakan, 50) }}</td>
                    <td>
                        @if($item->status === 'menunggu')
                            <span class="badge bg-label-warning">Menunggu</span>
                        @elseif($item->status === 'disetujui')
                            <span class="badge bg-label-info">Disetujui</span>
                        @elseif($item->status === 'diproses')
                            <span class="badge bg-label-primary">Proses</span>
                        @elseif($item->status === 'selesai')
                            <span class="badge bg-label-success">Selesai</span>
                        @else
                            <span class="badge bg-label-danger">Ditolak</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center">Data laporan tidak ditemukan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($laporan->hasPages())
    <div class="card-footer d-flex justify-content-end">
        {{ $laporan->links('pagination::bootstrap-5') }}
    </div>
    @endif
</div>

<div class="modal fade" id="modalFilter" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Filter Laporan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.rekap.index') }}" method="GET">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Rentang Tanggal</label>
                        <div class="input-group">
                            <input type="date" name="tgl_mulai" class="form-control" value="{{ request('tgl_mulai') }}">
                            <span class="input-group-text">s/d</span>
                            <input type="date" name="tgl_selesai" class="form-control" value="{{ request('tgl_selesai') }}">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Status Laporan</label>
                        <select name="status" class="form-select">
                            <option value="">Semua Status</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="proses" {{ request('status') == 'proses' ? 'selected' : '' }}>Proses</option>
                            <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                            <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <a href="{{ route('admin.rekap.index') }}" class="btn btn-outline-secondary">Reset</a>
                    <button type="submit" class="btn btn-primary">Terapkan Filter</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
