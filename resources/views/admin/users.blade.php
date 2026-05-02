@extends('layouts.app')

@section('title', 'Data Users')

@section('content')
<div class="row mb-4">
    <div class="col-12 d-flex flex-wrap justify-content-between align-items-center gap-3">
        <h4 class="fw-bold py-3 mb-0"> Data Users</h4>

        <div class="d-flex align-items-center gap-2">
            <form action="{{ route('admin.users.index') }}" method="GET" class="d-flex">
                <div class="input-group">
                    <input type="text" name="search" class="form-control" placeholder="Cari nama/email..." value="{{ request('search') }}">
                    <button type="submit" class="btn btn-outline-primary"><i class="bx bx-search"></i></button>
                    @if(request('search'))
                        <a href="{{ route('admin.users.index') }}" class="btn btn-outline-danger" title="Reset Pencarian"><i class="bx bx-x"></i></a>
                    @endif
                </div>
            </form>

            <button type="button" class="btn btn-primary text-nowrap" data-bs-toggle="modal" data-bs-target="#modalTambah">
                <i class="bx bx-plus me-1"></i> Tambah User
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
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Kecamatan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody class="table-border-bottom-0">
                @forelse ($users as $item)
                <tr>
                    <td>
                        <i class="icon-base bx bx-user text-primary me-3"></i>
                        <strong>{{ $item->nama }}</strong>
                    </td>
                    <td>{{ $item->email }}</td>
                    <td>{{ $item->kecamatan?->nama_kecamatan ?? '-' }}</td>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <button type="button" class="btn btn-sm btn-icon btn-outline-warning" data-bs-toggle="modal" data-bs-target="#modalEdit{{ $item->id_user }}" title="Edit">
                                <i class="bx bx-edit-alt"></i>
                            </button>
                            <form action="{{ route('admin.users.destroy', $item->id_user) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus user ini?');">
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
                    <td colspan="4" class="text-center">Data user belum tersedia atau tidak ditemukan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($users->hasPages())
    <div class="card-footer d-flex justify-content-end">
        {{ $users->withQueryString()->links('pagination::bootstrap-5') }}
    </div>
    @endif
</div>

@foreach ($users as $item)
<div class="modal fade" id="modalEdit{{ $item->id_user }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Data User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formEdit{{ $item->id_user }}" action="{{ route('admin.users.update', $item->id_user) }}" method="POST" novalidate>
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col">
                            <label class="form-label">Nama <span class="text-danger">*</span></label>
                            <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror" value="{{ $item->nama }}" placeholder="Nama lengkap" required />
                            <div class="invalid-feedback">
                                @error('nama') {{ $message }} @else Nama wajib diisi. @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <label class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ $item->email }}" placeholder="email@example.com" required />
                            <div class="invalid-feedback">
                                @error('email') {{ $message }} @else Email wajib diisi dan harus valid. @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <label class="form-label">Password Baru <small class="text-muted">(kosongkan jika tidak diubah)</small></label>
                            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Minimal 6 karakter" />
                            <div class="invalid-feedback">
                                @error('password') {{ $message }} @else Password minimal 6 karakter. @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <label class="form-label">Kecamatan</label>
                            <select name="id_kecamatan" class="form-select @error('id_kecamatan') is-invalid @enderror">
                                <option value="">-- Pilih Kecamatan (Opsional) --</option>
                                @foreach($kecamatan as $kec)
                                <option value="{{ $kec->id_kecamatan }}" {{ $item->id_kecamatan == $kec->id_kecamatan ? 'selected' : '' }}>
                                    {{ $kec->nama_kecamatan }}
                                </option>
                                @endforeach
                            </select>
                            @error('id_kecamatan') <div class="invalid-feedback">{{ $message }}</div> @enderror
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
                <h5 class="modal-title">Tambah User Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formTambah" action="{{ route('admin.users.store') }}" method="POST" novalidate>
                @csrf
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col">
                            <label for="nama_tambah" class="form-label">Nama <span class="text-danger">*</span></label>
                            <input type="text" id="nama_tambah" name="nama" class="form-control @error('nama') is-invalid @enderror" value="{{ old('nama') }}" placeholder="Nama lengkap" required />
                            <div class="invalid-feedback">
                                @error('nama') {{ $message }} @else Nama wajib diisi. @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <label for="email_tambah" class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email" id="email_tambah" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" placeholder="email@example.com" required />
                            <div class="invalid-feedback">
                                @error('email') {{ $message }} @else Email wajib diisi dan harus valid. @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <label for="password_tambah" class="form-label">Password <span class="text-danger">*</span></label>
                            <input type="password" id="password_tambah" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Minimal 6 karakter" required minlength="6" />
                            <div class="invalid-feedback">
                                @error('password') {{ $message }} @else Password wajib diisi, minimal 6 karakter. @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <label for="kecamatan_tambah" class="form-label">Kecamatan</label>
                            <select id="kecamatan_tambah" name="id_kecamatan" class="form-select @error('id_kecamatan') is-invalid @enderror">
                                <option value="">-- Pilih Kecamatan (Opsional) --</option>
                                @foreach($kecamatan as $kec)
                                <option value="{{ $kec->id_kecamatan }}" {{ old('id_kecamatan') == $kec->id_kecamatan ? 'selected' : '' }}>
                                    {{ $kec->nama_kecamatan }}
                                </option>
                                @endforeach
                            </select>
                            @error('id_kecamatan') <div class="invalid-feedback">{{ $message }}</div> @enderror
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
