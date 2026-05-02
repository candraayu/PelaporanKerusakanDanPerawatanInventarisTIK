@extends('layouts.app')

@section('title', 'Laporan Kerusakan')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <h4 class="fw-bold py-3 mb-0">Laporan Kerusakan</h4>
    </div>
</div>

<div class="card">
    <div class="table-responsive text-nowrap">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Inventaris</th>
                    <th>Pelapor</th>
                    <th>Deskripsi</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody class="table-border-bottom-0">
                @forelse ($laporan as $item)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($item->tanggal_laporan)->format('d/m/Y') }}</td>
                    <td>
                        <i class="icon-base bx bx-wrench text-warning me-2"></i>
                        <strong>{{ $item->inventaris?->nama_barang ?? '-' }}</strong>
                        <br>
                        <small class="text-muted">{{ $item->inventaris?->kode_inventaris ?? '' }}</small>
                    </td>
                    <td>{{ $item->user?->nama ?? '-' }}</td>
                    <td>
                        <span class="text-truncate d-inline-block" style="max-width: 200px;">
                            {{ $item->deskripsi_kerusakan }}
                        </span>
                    </td>
                    <td>
                        @if($item->status === 'menunggu')
                            <span class="badge bg-secondary">Menunggu</span>
                        @elseif($item->status === 'disetujui')
                            <span class="badge bg-info">Disetujui</span>
                        @elseif($item->status === 'ditolak')
                            <span class="badge bg-danger">Ditolak</span>
                        @elseif($item->status === 'diproses')
                            <span class="badge bg-warning">Diproses</span>
                        @else
                            <span class="badge bg-success">Selesai</span>
                        @endif
                    </td>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <a href="{{ route('admin.laporan.show', $item->id_laporan) }}" class="btn btn-sm btn-icon btn-outline-info" title="Lihat Detail">
                                <i class="bx bx-show"></i>
                            </a>
                            @if($item->status === 'disetujui')
                            <form action="{{ route('admin.laporan.diproses', $item->id_laporan) }}" method="POST" class="d-inline">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="btn btn-sm btn-icon btn-outline-warning" title="Proses">
                                    <i class="bx bx-cog"></i>
                                </button>
                            </form>
                            @endif
                            @if($item->status === 'diproses')
                            <form action="{{ route('admin.laporan.selesai', $item->id_laporan) }}" method="POST" class="d-inline">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="btn btn-sm btn-icon btn-outline-success" title="Selesai">
                                    <i class="bx bx-check"></i>
                                </button>
                            </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center">Belum ada laporan kerusakan.</td>
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
@endsection
