@extends('layouts.app')

@section('title', 'Data Kecamatan')

@section('content')
<div class="row mb-4">
    <div class="col-12 d-flex flex-wrap justify-content-between align-items-center gap-3">
        <h4 class="fw-bold py-3 mb-0"> Data Kecamatan</h4>

        <div class="d-flex align-items-center gap-2">
            <form action="{{ route('admin.kecamatan.index') }}" method="GET" class="d-flex">
                <div class="input-group">
                    <input type="text" name="search" class="form-control" placeholder="Cari nama/kode..." value="{{ request('search') }}">
                    <button type="submit" class="btn btn-outline-primary"><i class="bx bx-search"></i></button>
                    @if(request('search'))
                        <a href="{{ route('admin.kecamatan.index') }}" class="btn btn-outline-danger" title="Reset Pencarian"><i class="bx bx-x"></i></a>
                    @endif
                </div>
            </form>

            <button type="button" class="btn btn-primary text-nowrap" data-bs-toggle="modal" data-bs-target="#modalTambah">
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
                    <th>Kode Kecamatan</th>
                    <th>Nama Kecamatan</th>
                    <th>Alamat</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody class="table-border-bottom-0">
                @forelse ($kecamatan as $item)
                <tr>
                    <td>
                        <strong>{{ $item->kode_kecamatan }}</strong>
                    </td>
                    <td>
                        <i class="icon-base bx bx-map-alt text-success me-3"></i>
                        <strong>{{ $item->nama_kecamatan }}</strong>
                    </td>

                    <td>
                        {{ $item->alamat ?? '-' }}
                    </td>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <button type="button" class="btn btn-sm btn-icon btn-outline-warning" data-bs-toggle="modal" data-bs-target="#modalEdit{{ $item->id_kecamatan }}" title="Edit">
                                <i class="bx bx-edit-alt"></i>
                            </button>

                            <form action="{{ route('admin.kecamatan.destroy', $item->id_kecamatan) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kecamatan ini?');">
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
                    <td colspan="4" class="text-center">Data kecamatan belum tersedia atau tidak ditemukan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($kecamatan->hasPages())
    <div class="card-footer d-flex justify-content-end">
        {{ $kecamatan->withQueryString()->links('pagination::bootstrap-5') }}
    </div>
    @endif
</div>

@foreach ($kecamatan as $item)
<div class="modal fade" id="modalEdit{{ $item->id_kecamatan }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalCenterTitle">Edit Data Kecamatan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formEdit{{ $item->id_kecamatan }}" action="{{ route('admin.kecamatan.update', $item->id_kecamatan) }}" method="POST" novalidate>
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col">
                            <label class="form-label">Kode Kecamatan <span class="text-danger">*</span></label>
                            <input type="text" name="kode_kecamatan" class="form-control @error('kode_kecamatan') is-invalid @enderror" value="{{ $item->kode_kecamatan }}" placeholder="Contoh: KEC-01" required maxlength="8" />
                            <small class="text-muted">Maksimal 8 karakter.</small>
                            <div class="invalid-feedback">
                                @error('kode_kecamatan') {{ $message }} @else Kode kecamatan wajib diisi (Maks 8 Karakter). @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <label class="form-label">Nama Kecamatan <span class="text-danger">*</span></label>
                            <input type="text" name="nama_kecamatan" class="form-control @error('nama_kecamatan') is-invalid @enderror" value="{{ $item->nama_kecamatan }}" placeholder="Contoh: Kecamatan Sukamaju" required />
                            <div class="invalid-feedback">
                                @error('nama_kecamatan') {{ $message }} @else Nama kecamatan wajib diisi. @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <label class="form-label">Kontak <span class="text-danger">*</span></label>
                            <input type="text" name="kontak" class="form-control @error('kontak') is-invalid @enderror" value="{{ $item->kontak }}" placeholder="Contoh: 08123456789" required />
                            <div class="invalid-feedback">
                                @error('kontak') {{ $message }} @else Kontak wajib diisi. @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <label class="form-label">Alamat</label>
                            <textarea name="alamat" class="form-control @error('alamat') is-invalid @enderror" rows="3" placeholder="Masukkan alamat lengkap (Opsional)">{{ $item->alamat }}</textarea>
                            @error('alamat') <div class="invalid-feedback">{{ $message }}</div> @enderror
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
                <h5 class="modal-title" id="modalCenterTitle">Tambah Kecamatan Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formTambah" action="{{ route('admin.kecamatan.store') }}" method="POST" novalidate>
                @csrf
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col">
                            <label for="kode_kecamatan_tambah" class="form-label">Kode Kecamatan <span class="text-danger">*</span></label>
                            <input type="text" id="kode_kecamatan_tambah" name="kode_kecamatan" class="form-control @error('kode_kecamatan') is-invalid @enderror" value="{{ old('kode_kecamatan') }}" placeholder="Contoh: KEC-01" required maxlength="8" />
                            <small class="text-muted">Maksimal 8 karakter.</small>
                            <div class="invalid-feedback">
                                @error('kode_kecamatan') {{ $message }} @else Kode kecamatan wajib diisi (Maks 8 Karakter). @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <label for="nama_kecamatan_tambah" class="form-label">Nama Kecamatan <span class="text-danger">*</span></label>
                            <input type="text" id="nama_kecamatan_tambah" name="nama_kecamatan" class="form-control @error('nama_kecamatan') is-invalid @enderror" value="{{ old('nama_kecamatan') }}" placeholder="Contoh: Kecamatan Sukamaju" required />
                            <div class="invalid-feedback">
                                @error('nama_kecamatan') {{ $message }} @else Nama kecamatan wajib diisi. @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <label for="kontak_tambah" class="form-label">Kontak <span class="text-danger">*</span></label>
                            <input type="text" id="kontak_tambah" name="kontak" class="form-control @error('kontak') is-invalid @enderror" value="{{ old('kontak') }}" placeholder="Contoh: 08123456789" required />
                            <div class="invalid-feedback">
                                @error('kontak') {{ $message }} @else Kontak wajib diisi. @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <label for="alamat_tambah" class="form-label">Alamat</label>
                            <textarea id="alamat_tambah" name="alamat" class="form-control @error('alamat') is-invalid @enderror" rows="3" placeholder="Masukkan alamat lengkap (Opsional)">{{ old('alamat') }}</textarea>
                            @error('alamat') <div class="invalid-feedback">{{ $message }}</div> @enderror
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
        const kodeInputs = document.querySelectorAll('input[name="kode_kecamatan"]');
        kodeInputs.forEach(input => {
            input.addEventListener('input', function() {
                if (this.value.length > 8) {
                    this.value = this.value.slice(0, 8);
                }
            });
        });
    });
</script>
@endpush
