@extends('layouts.app')

@section('title', 'Laporan Kerusakan')

@section('content')
<div class="row mb-4">
    <div class="col-12 d-flex justify-content-between align-items-center">
        <h4 class="fw-bold py-3 mb-0">Laporan Kerusakan</h4>

        <div class="d-flex gap-2">

            {{-- Search --}}
            <form action="{{ route('admin.laporan.index') }}" method="GET" class="d-flex gap-2">
                <input type="hidden" name="status" value="{{ request('status') }}">

                <div class="input-group input-group-sm">
                    <input
                        type="text"
                        name="search"
                        class="form-control"
                        placeholder="Cari laporan..."
                        value="{{ request('search') }}"
                    >

                    <button class="btn btn-primary" type="submit">
                        <i class="bx bx-search"></i>
                    </button>

                    @if(request('search'))
                        <a href="{{ route('admin.laporan.index', ['status' => request('status')]) }}"
                           class="btn btn-outline-secondary">
                            <i class="bx bx-x"></i>
                        </a>
                    @endif
                </div>
            </form>

            {{-- Filter Status --}}
            <form action="{{ route('admin.laporan.index') }}" method="GET">
                <input type="hidden" name="search" value="{{ request('search') }}">

                <select name="status"
                        class="form-select form-select-sm"
                        onchange="this.form.submit()">

                    <option value="">Semua Status</option>

                    <option value="menunggu"
                        {{ request('status') == 'menunggu' ? 'selected' : '' }}>
                        Menunggu
                    </option>

                    <option value="disetujui"
                        {{ request('status') == 'disetujui' ? 'selected' : '' }}>
                        Disetujui
                    </option>

                    <option value="ditolak"
                        {{ request('status') == 'ditolak' ? 'selected' : '' }}>
                        Ditolak
                    </option>

                    <option value="diproses"
                        {{ request('status') == 'diproses' ? 'selected' : '' }}>
                        Diproses
                    </option>

                    <option value="selesai"
                        {{ request('status') == 'selesai' ? 'selected' : '' }}>
                        Selesai
                    </option>

                </select>
            </form>
        </div>
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
        {{ $laporan->appends([
        'search' => request('search'),
        'status' => request('status')
        ])->links('pagination::bootstrap-5') }}
    </div>
    @endif
</div>
@endsection
