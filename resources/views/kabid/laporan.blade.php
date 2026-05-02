@extends('layouts.app')

@section('title', 'Laporan Kerusakan')

@section('content')
<div class="row mb-4">
    <div class="col-12 d-flex justify-content-between align-items-center">
        <h4 class="fw-bold py-3 mb-0">Laporan Kerusakan</h4>
        <div class="d-flex gap-2">
            <form action="{{ route('kabid.laporan.index') }}" method="GET" class="d-flex gap-2">
                <input type="hidden" name="status" value="{{ request('status') }}">
                <div class="input-group input-group-sm">
                    <input type="text" name="search" class="form-control" placeholder="Cari laporan..." value="{{ request('search') }}">
                    <button class="btn btn-primary" type="submit">
                        <i class="bx bx-search"></i>
                    </button>
                    @if(request('search'))
                        <a href="{{ route('kabid.laporan.index', ['status' => request('status')]) }}" class="btn btn-outline-secondary">
                            <i class="bx bx-x"></i>
                        </a>
                    @endif
                </div>
            </form>
            <form action="{{ route('kabid.laporan.index') }}" method="GET" class="d-flex gap-2">
                <input type="hidden" name="search" value="{{ request('search') }}">
                <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
                    <option value="">Semua Status</option>
                    <option value="menunggu" {{ request('status') == 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                    <option value="disetujui" {{ request('status') == 'disetujui' ? 'selected' : '' }}>Disetujui</option>
                    <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                    <option value="diproses" {{ request('status') == 'diproses' ? 'selected' : '' }}>Diproses</option>
                    <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
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
                    <th>Pelapor</th>
                    <th>Nama Barang</th>
                    <th>Kecamatan</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody class="table-border-bottom-0">
                @forelse ($laporan as $item)
                <tr>
                    <td>{{ $item->created_at->format('d/m/Y') }}</td>
                    <td>{{ $item->user->nama }}</td>
                    <td>{{ $item->inventaris->nama_barang }}</td>
                    <td>{{ $item->inventaris->kecamatan?->nama_kecamatan ?? '-' }}</td>
                    <td>
                        @if($item->status === 'menunggu')
                            <span class="badge bg-warning">Menunggu</span>
                        @elseif($item->status === 'disetujui')
                            <span class="badge bg-info">Disetujui</span>
                        @elseif($item->status === 'ditolak')
                            <span class="badge bg-danger">Ditolak</span>
                        @elseif($item->status === 'diproses')
                            <span class="badge bg-primary">Diproses</span>
                        @else
                            <span class="badge bg-success">Selesai</span>
                        @endif
                    </td>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <button type="button" class="btn btn-sm btn-icon btn-outline-info" data-bs-toggle="modal" data-bs-target="#modalShow{{ $item->id_laporan }}" title="Detail">
                                <i class="bx bx-show"></i>
                            </button>

                             @if($item->status === 'menunggu')
                            <div class="d-flex gap-1">
                                <form action="{{ route('kabid.laporan.setujui', $item->id_laporan) }}" method="POST" onsubmit="return confirm('Setujui laporan ini?');">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="btn btn-sm btn-icon btn-outline-success" title="Setujui">
                                        <i class="bx bx-check"></i>
                                    </button>
                                </form>
                                <form action="{{ route('kabid.laporan.tolak', $item->id_laporan) }}" method="POST" onsubmit="return confirm('Tolak laporan ini?');">
                                    @csrf
                                    @method('PUT')
                                   <button type="button"
                                        class="btn btn-sm btn-icon btn-outline-danger"
                                        data-bs-toggle="modal"
                                        data-bs-target="#modalTolak{{ $item->id_laporan }}"
                                        title="Tolak">
                                        <i class="bx bx-x"></i>
                                    </button>
                                </form>
                            </div>
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
        {{ $laporan->appends(['status' => request('status'), 'search' => request('search')])->links('pagination::bootstrap-5') }}
    </div>
    @endif
</div>

@foreach ($laporan as $item)
<div class="modal fade" id="modalShow{{ $item->id_laporan }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Laporan Kerusakan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row g-3">
                    <div class="col-6">
                        <small class="text-muted d-block">Kode Inventaris</small>
                        <span class="fw-bold text-primary">{{ $item->inventaris->kode_inventaris }}</span>
                    </div>
                    <div class="col-6">
                        <small class="text-muted d-block">Tanggal Lapor</small>
                        <span class="fw-bold">{{ $item->created_at->translatedFormat('d F Y') }}</span>
                    </div>
                    <div class="col-12 border-top pt-2">
                        <small class="text-muted d-block">Nama Barang</small>
                        <p class="mb-2 fw-bold">{{ $item->inventaris->nama_barang }}</p>
                    </div>
                    <div class="col-12">
                        <small class="text-muted d-block">Deskripsi Kerusakan</small>
                        <p class="mb-2">{{ $item->deskripsi_kerusakan ?? 'Tidak ada deskripsi.' }}</p>
                            @if($item->status === 'ditolak')
                                <div class="col-12">
                                    <small class="text-muted d-block">Alasan Penolakan</small>

                                    <div class="alert alert-danger mt-1 mb-2">
                                        {{ $item->catatan->last()?->catatan ?? 'Tidak ada catatan' }}
                                    </div>
                                </div>
                            @endif
                    </div>
                    <div class="col-6">
                        <small class="text-muted d-block">Pelapor</small>
                        <p class="mb-0">{{ $item->user->nama }}</p>
                    </div>
                    <div class="col-6">
                        <small class="text-muted d-block">Status Saat Ini</small>
                        @if($item->status === 'menunggu')
                            <span class="badge bg-warning">Menunggu</span>
                        @elseif($item->status === 'disetujui')
                            <span class="badge bg-info">Disetujui</span>
                        @elseif($item->status === 'ditolak')
                            <span class="badge bg-danger">Ditolak</span>
                        @elseif($item->status === 'diproses')
                            <span class="badge bg-primary">Diproses</span>
                        @else
                            <span class="badge bg-success">Selesai</span>
                        @endif
                    </div>
                    @if($item->foto)
                    <div class="col-12 border-top pt-2">
                        <small class="text-muted d-block mb-2">Foto Kerusakan</small>
                        <img src="{{ asset('storage/' . $item->foto) }}" class="img-fluid rounded shadow-sm" alt="Foto Kerusakan">
                    </div>
                    @endif
                </div>
            </div>
            @if($item->catatan && $item->catatan->count())
                <div class="col-12 border-top pt-2">
                    <small class="text-muted d-block mb-2">Catatan</small>

                    @foreach($item->catatan as $catatan)
                    <div class="p-2 mb-2 rounded bg-light">
                        <div class="d-flex justify-content-between">
                            <strong>
                                {{ $catatan->user?->nama ?? 'User' }}
                            </strong>
                            <small>{{ \Carbon\Carbon::parse($catatan->tanggal)->format('d/m/Y') }}</small>
                        </div>

                        <div>{{ $catatan->catatan }}</div>
                    </div>
                    @endforeach
                </div>
            @endif
            <div class="modal-footer">
                @if($item->status === 'menunggu')
                <div class="d-flex gap-2">
                    <form action="{{ route('kabid.laporan.setujui', $item->id_laporan) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <button type="submit" class="btn btn-success">
                            Disetujui
                        </button>
                    </form>
                    <button type="button"
                        class="btn btn-danger"
                        data-bs-toggle="modal"
                        data-bs-target="#modalTolak{{ $item->id_laporan }}">
                        Tolak Laporan
                    </button>
                </div>
                @endif
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalTolak{{ $item->id_laporan }}">
    <div class="modal-dialog">
       <form action="{{ route('kabid.laporan.tolak', $item->id_laporan) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tolak Laporan</h5>
                </div>

                <div class="modal-body">
                    <label>Alasan Penolakan</label>
                    <textarea name="catatan" class="form-control" required></textarea>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">Tolak</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endforeach

@endsection
