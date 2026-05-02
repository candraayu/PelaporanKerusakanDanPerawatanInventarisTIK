@extends('layouts.app')

@section('title', 'Data Perawatan Barang')

@section('content')
<div class="row mb-4">
    <div class="col-12 d-flex justify-content-between align-items-center">
        <h4 class="fw-bold py-3 mb-0"> Data Perawatan Barang</h4>
        <div class="d-flex gap-2">
            <form action="{{ route('operator.perawatan.index') }}" method="GET" class="d-flex gap-2">
                <div class="input-group input-group-sm">
                    <input type="text" name="search" class="form-control" placeholder="Cari perawatan..." value="{{ request('search') }}">
                    <button class="btn btn-primary" type="submit">
                        <i class="bx bx-search"></i>
                    </button>
                    @if(request('search'))
                        <a href="{{ route('operator.perawatan.index') }}" class="btn btn-outline-secondary">
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
                    <th>Jenis Perawatan</th>
                    <th>Keterangan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody class="table-border-bottom-0">
                @forelse ($perawatan as $item)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($item->tanggal_perawatan)->format('d/m/Y') }}</td>
                    <td>
                        <strong>{{ $item->inventaris?->nama_barang ?? '-' }}</strong><br>
                        <small class="text-muted">{{ $item->inventaris?->kode_inventaris ?? '-' }}</small>
                    </td>
                    <td><span class="badge bg-label-info">{{ $item->jenis_perawatan }}</span></td>
                    <td>
                        <span class="d-inline-block text-truncate" style="max-width: 200px;" title="{{ $item->keterangan }}">
                            {{ $item->keterangan ?? '-' }}
                        </span>
                    </td>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <button type="button" class="btn btn-sm btn-icon btn-outline-warning" data-bs-toggle="modal" data-bs-target="#modalEdit{{ $item->id_perawatan }}" title="Edit">
                                <i class="bx bx-edit-alt"></i>
                            </button>

                            <form action="{{ route('operator.perawatan.destroy', $item->id_perawatan) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data perawatan ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-icon btn-outline-danger" title="Hapus">
                                    <i class="bx bx-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center">Data perawatan belum tersedia.</td>
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

{{-- Modal Edit --}}
@foreach ($perawatan as $item)
<div class="modal fade" id="modalEdit{{ $item->id_perawatan }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Data Perawatan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formEdit{{ $item->id_perawatan }}" action="{{ route('operator.perawatan.update', $item->id_perawatan) }}" method="POST" novalidate>
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col">
                            <label class="form-label">Pilih Barang <span class="text-danger">*</span></label>
                            <select name="id_inventaris" class="form-select @error('id_inventaris') is-invalid @enderror" required>
                                <option value="">-- Pilih Barang --</option>
                                {{-- Pastikan variabel $inventaris dikirim dari controller --}}
                                @foreach($inventaris as $inv)
                                <option value="{{ $inv->id_inventaris }}" {{ $item->id_inventaris == $inv->id_inventaris ? 'selected' : '' }}>
                                    {{ $inv->kode_inventaris }} - {{ $inv->nama_barang }}
                                </option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback">Barang wajib dipilih.</div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Tanggal Perawatan <span class="text-danger">*</span></label>
                            <input type="date" name="tanggal_perawatan" class="form-control @error('tanggal_perawatan') is-invalid @enderror" value="{{ \Carbon\Carbon::parse($item->tanggal_perawatan)->format('Y-m-d') }}" required />
                            <div class="invalid-feedback">Tanggal wajib diisi.</div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Jenis Perawatan <span class="text-danger">*</span></label>
                            <input type="text" name="jenis_perawatan" class="form-control @error('jenis_perawatan') is-invalid @enderror" value="{{ $item->jenis_perawatan }}" placeholder="Contoh: Perawatan Rutin" required />
                            <div class="invalid-feedback">Jenis perawatan wajib diisi.</div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <label class="form-label">Keterangan</label>
                            <textarea name="keterangan" class="form-control @error('keterangan') is-invalid @enderror" rows="3" placeholder="Masukkan detail perawatan (Opsional)">{{ $item->keterangan }}</textarea>
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
@endforeach

<div class="modal fade" id="modalTambah" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Perawatan Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formTambah" action="{{ route('operator.perawatan.store') }}" method="POST" novalidate>
                @csrf
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col">
                            <label class="form-label">Pilih Barang <span class="text-danger">*</span></label>
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
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Tanggal Perawatan <span class="text-danger">*</span></label>
                            <input type="date" name="tanggal_perawatan" class="form-control @error('tanggal_perawatan') is-invalid @enderror" value="{{ old('tanggal_perawatan', date('Y-m-d')) }}" required />
                            <div class="invalid-feedback">Tanggal wajib diisi.</div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Jenis Perawatan <span class="text-danger">*</span></label>
                            <input type="text" name="jenis_perawatan" class="form-control @error('jenis_perawatan') is-invalid @enderror" value="{{ old('jenis_perawatan') }}" placeholder="Contoh: Perawatan Rutin" required />
                            <div class="invalid-feedback">Jenis perawatan wajib diisi.</div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <label class="form-label">Keterangan</label>
                            <textarea name="keterangan" class="form-control @error('keterangan') is-invalid @enderror" rows="3" placeholder="Masukkan detail perawatan (Opsional)">{{ old('keterangan') }}</textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Simpan Data</button>
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
</script>
@endpush
