@extends('layouts.app')

@section('title', 'Data Laporan Kerusakan')

@section('content')
<div class="row mb-4">
    <div class="col-12 d-flex justify-content-between align-items-center">
        <h4 class="fw-bold py-3 mb-0"> Data Laporan Kerusakan</h4>
        <div class="d-flex gap-2">
            <form action="{{ route('operator.laporan.index') }}" method="GET" class="d-flex gap-2">
                <div class="input-group input-group-sm">
                    <input type="text" name="search" class="form-control" placeholder="Cari laporan..." value="{{ request('search') }}">
                    <button class="btn btn-primary" type="submit">
                        <i class="bx bx-search"></i>
                    </button>
                    @if(request('search'))
                        <a href="{{ route('operator.laporan.index') }}" class="btn btn-outline-secondary">
                            <i class="bx bx-x"></i>
                        </a>
                    @endif
                </div>
            </form>
            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalTambah">
                <i class="bx bx-plus me-1"></i> Tambah
            </button>
        </div>
    </div>
</div>

@if ($errors->any())
<div class="alert alert-danger alert-dismissible" role="alert">
    Terdapat kesalahan pada inputan Anda. Silakan periksa kembali.
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

<div class="card">
    <div class="table-responsive text-nowrap">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Barang (Kode)</th>
                    <th>Deskripsi</th>
                    <th>Foto</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody class="table-border-bottom-0">
                @forelse ($laporan as $item)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($item->tanggal_laporan)->format('d/m/Y') }}</td>
                    <td>
                        <strong>{{ $item->inventaris?->nama_barang ?? '-' }}</strong><br>
                        <small class="text-muted">{{ $item->inventaris?->kode_inventaris ?? '-' }}</small>
                    </td>
                    <td>
                        <span class="d-inline-block text-truncate" style="max-width: 200px;" title="{{ $item->deskripsi_kerusakan }}">
                            {{ $item->deskripsi_kerusakan }}
                        </span>
                    </td>
                    <td>
                        @if($item->foto)
                            <a href="{{ asset('storage/' . $item->foto) }}" target="_blank" class="btn btn-sm btn-outline-info">
                                <i class="bx bx-image"></i> Lihat
                            </a>
                        @else
                            <span class="text-muted">-</span>
                        @endif
                    </td>
                    <td>
                        @if($item->status === 'menunggu')
                            <span class="badge bg-warning">Menunggu</span>
                        @elseif($item->status === 'diproses')
                            <span class="badge bg-info">Diproses</span>
                        @elseif($item->status === 'selesai')
                            <span class="badge bg-success">Selesai</span>
                        @elseif($item->status === 'ditolak')
                            <span class="badge bg-danger">Ditolak</span>
                        @else
                            <span class="badge bg-secondary">{{ $item->status }}</span>
                        @endif
                    </td>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <button type="button" class="btn btn-sm btn-icon btn-outline-info" data-bs-toggle="modal" data-bs-target="#modalDetail{{ $item->id_laporan }}" title="Detail">
                                <i class="bx bx-show"></i>
                            </button>
                            @if($item->status === 'menunggu')
                                <button type="button" class="btn btn-sm btn-icon btn-outline-warning" data-bs-toggle="modal" data-bs-target="#modalEdit{{ $item->id_laporan }}" title="Edit">
                                    <i class="bx bx-edit-alt"></i>
                                </button>
                                <form action="{{ route('operator.laporan.destroy', $item->id_laporan) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus laporan ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-icon btn-outline-danger" title="Hapus">
                                        <i class="bx bx-trash"></i>
                                    </button>
                                </form>
                            @else
                                <span class="badge bg-label-secondary"><i class="bx bx-lock-alt me-1"></i> Tidak Dapat Diubah</span>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center">Data laporan kerusakan belum tersedia.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($laporan->hasPages())
    <div class="card-footer d-flex justify-content-end">
        {{ $laporan->appends(['search' => request('search')])->links('pagination::bootstrap-5') }}
    </div>
    @endif
</div>

@foreach ($laporan as $item)
@if($item->status === 'menunggu')
<div class="modal fade" id="modalEdit{{ $item->id_laporan }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Laporan Kerusakan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formEdit{{ $item->id_laporan }}" action="{{ route('operator.laporan.update', $item->id_laporan) }}" method="POST" enctype="multipart/form-data" novalidate>
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Pilih Barang (Inventaris) <span class="text-danger">*</span></label>
                            <select name="id_inventaris" class="form-select @error('id_inventaris') is-invalid @enderror" required>
                                <option value="">-- Pilih Barang --</option>
                                @foreach($inventaris as $inv)
                                <option value="{{ $inv->id_inventaris }}" {{ $item->id_inventaris == $inv->id_inventaris ? 'selected' : '' }}>
                                    {{ $inv->kode_inventaris }} - {{ $inv->nama_barang }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Tanggal Laporan <span class="text-danger">*</span></label>
                            <input type="date" name="tanggal_laporan" class="form-control @error('tanggal_laporan') is-invalid @enderror" value="{{ \Carbon\Carbon::parse($item->tanggal_laporan)->format('Y-m-d') }}" required />
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-12">
                            <label class="form-label">Deskripsi Kerusakan <span class="text-danger">*</span></label>
                            <textarea name="deskripsi_kerusakan" rows="3" class="form-control @error('deskripsi_kerusakan') is-invalid @enderror" required>{{ $item->deskripsi_kerusakan }}</textarea>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-12 text-center">
                            <label class="form-label d-block text-start">Bukti Foto</label>
                            <div class="mb-3">
                                @if($item->foto)
                                    <img id="previewEdit{{ $item->id_laporan }}" src="{{ asset('storage/' . $item->foto) }}" alt="Preview" class="img-thumbnail" style="max-height: 200px;">
                                @else
                                    <img id="previewEdit{{ $item->id_laporan }}" src="{{ asset('assets/img/elements/18.jpg') }}" alt="No Image" class="img-thumbnail" style="max-height: 200px;">
                                @endif
                                <p class="small text-muted mt-1">Preview Foto</p>
                            </div>

                            <input type="file" name="foto" class="form-control @error('foto') is-invalid @enderror"
                                   accept="image/jpeg, image/png, image/jpg"
                                   onchange="previewImage(this, 'previewEdit{{ $item->id }}')" />
                            <small class="text-muted d-block text-start">Opsional, max 2MB. Pilih file baru untuk mengganti.</small>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Update Data</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif
@endforeach

@foreach ($laporan as $item)
<div class="modal fade" id="modalDetail{{ $item->id_laporan }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header border-bottom">
                <h5 class="modal-title">Detail Laporan & Catatan Admin</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row mb-4">
                    <div class="col-md-7">
                        <h6 class="fw-bold mb-3"><i class="bx bx-info-circle me-1"></i> Informasi Laporan</h6>
                        <table class="table table-sm table-borderless">
                            <tr>
                                <td width="130" class="text-muted">Tanggal</td>
                                <td>: {{ \Carbon\Carbon::parse($item->tanggal_laporan)->translatedFormat('d F Y') }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted">Barang</td>
                                <td>: {{ $item->inventaris?->nama_barang }} <small class="text-muted">({{ $item->inventaris?->kode_inventaris }})</small></td>
                            </tr>
                            <tr>
                                <td class="text-muted">Status</td>
                                <td>: 
                                    @if($item->status === 'menunggu')
                                        <span class="badge bg-warning">Menunggu</span>
                                    @elseif($item->status === 'diproses')
                                        <span class="badge bg-info">Diproses</span>
                                    @elseif($item->status === 'selesai')
                                        <span class="badge bg-success">Selesai</span>
                                    @elseif($item->status === 'ditolak')
                                        <span class="badge bg-danger">Ditolak</span>
                                        <div class="alert alert-danger mt-2">
                                            <strong>Alasan Penolakan:</strong><br>
                                            {{ $item->catatan->last()?->catatan ?? 'Tidak ada catatan' }}
                                        </div>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="text-muted" style="vertical-align: top;">Deskripsi</td>
                                <td>: {{ $item->deskripsi_kerusakan }}</td>
                            </tr>
                        </table>
                        
                        @if($item->foto)
                        <div class="mt-3">
                            <small class="text-muted d-block mb-2">Foto Kerusakan:</small>
                            <img src="{{ asset('storage/' . $item->foto) }}" class="img-fluid rounded border" style="max-height: 200px;">
                        </div>
                        @endif
                    </div>
                    <div class="col-md-5 border-start">
                        <h6 class="fw-bold mb-3"><i class="bx bx-comment-detail me-1"></i> Catatan</h6>
                        <div class="catatan-container" style="max-height: 350px; overflow-y: auto;">
                            @forelse($item->catatan as $catatan)
                            <div class="card mb-2 bg-light shadow-none border">
                                <div class="card-body p-2">
                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                        <small class="fw-bold text-primary">
                                            {{ $catatan->user?->nama }}
                                        </small>
                                        <small class="text-muted" style="font-size: 0.75rem;">{{ \Carbon\Carbon::parse($catatan->tanggal)->format('d/m/Y') }}</small>
                                    </div>
                                    <p class="mb-0 small">{{ $catatan->catatan }}</p>
                                </div>
                            </div>
                            @empty
                            <div class="text-center py-4 text-muted">
                                <i class="bx bx-note fs-1 d-block mb-1"></i>
                                <p class="small mb-0">Belum ada catatan dari admin.</p>
                            </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
@endforeach

<div class="modal fade" id="modalTambah" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Laporan Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formTambah" action="{{ route('operator.laporan.store') }}" method="POST" enctype="multipart/form-data" novalidate>
                @csrf
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Pilih Barang (Inventaris) <span class="text-danger">*</span></label>
                            <select name="id_inventaris" class="form-select @error('id_inventaris') is-invalid @enderror" required>
                                <option value="">-- Pilih Barang --</option>
                                @foreach($inventaris as $inv)
                                <option value="{{ $inv->id_inventaris }}" {{ old('id_inventaris') == $inv->id_inventaris ? 'selected' : '' }}>
                                    {{ $inv->kode_inventaris }} - {{ $inv->nama_barang }}
                                </option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback">Barang wajib dipilih.</div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Tanggal Laporan <span class="text-danger">*</span></label>
                            <input type="date" name="tanggal_laporan" class="form-control @error('tanggal_laporan') is-invalid @enderror" value="{{ old('tanggal_laporan', date('Y-m-d')) }}" required />
                            <div class="invalid-feedback">Tanggal wajib diisi.</div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12">
                            <label class="form-label">Deskripsi Kerusakan <span class="text-danger">*</span></label>
                            <textarea name="deskripsi_kerusakan" rows="3" class="form-control @error('deskripsi_kerusakan') is-invalid @enderror" placeholder="Jelaskan kerusakan secara detail..." required>{{ old('deskripsi_kerusakan') }}</textarea>
                            <div class="invalid-feedback">Deskripsi kerusakan wajib diisi.</div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12">
                            <label class="form-label">Bukti Foto <span class="text-muted">(Opsional, max 2MB, JPG/PNG)</span></label>
                            <input type="file" name="foto" class="form-control @error('foto') is-invalid @enderror" accept="image/jpeg, image/png, image/jpg" />
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Simpan Laporan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('form[novalidate]').forEach(function (form) {
            form.addEventListener('submit', function (event) {
                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);
        });
        @if($errors->any() && !old('_method'))
        var myModal = new bootstrap.Modal(document.getElementById('modalTambah'));
        myModal.show();
        @endif
    });
     function previewImage(input, previewId) {
        const preview = document.getElementById(previewId);
        const file = input.files[0];
        const reader = new FileReader();

        reader.onload = function(e) {
            preview.src = e.target.result;
        }

        if (file) {
            reader.readAsDataURL(file);
        }
    }
</script>
@endpush
