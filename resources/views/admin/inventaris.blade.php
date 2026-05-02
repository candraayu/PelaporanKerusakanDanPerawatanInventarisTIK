@extends('layouts.app')

@section('title', 'Data Inventaris')

@section('content')
<div class="row mb-4">
    <div class="col-12 d-flex flex-wrap justify-content-between align-items-center gap-3">
        <h4 class="fw-bold py-3 mb-0"> Data Inventaris</h4>

        <div class="d-flex align-items-center gap-2">
            <form action="{{ route('admin.inventaris.index') }}" method="GET" class="d-flex">
                <div class="input-group">
                    <input type="text" name="search" class="form-control" placeholder="Cari kecamatan/kode/nama/kategori..." value="{{ request('search') }}">
                    <button type="submit" class="btn btn-outline-primary"><i class="bx bx-search"></i></button>
                    @if(request('search'))
                        <a href="{{ route('admin.inventaris.index') }}" class="btn btn-outline-danger" title="Reset Pencarian"><i class="bx bx-x"></i></a>
                    @endif
                </div>
            </form>

            <button type="button" class="btn btn-primary text-nowrap" data-bs-toggle="modal" data-bs-target="#modalTambah">
                <i class="bx bx-plus me-1"></i> Tambah
            </button>
        </div>
    </div>
</div>

@if(session('success'))
<div class="alert alert-success alert-dismissible" role="alert">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

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
                    <th>Kode</th>
                    <th>Nama Barang</th>
                    <th>Kategori</th>
                    <th>Merk / Tipe</th>
                    <th>Tahun</th>
                    <th>Jumlah</th>
                    <th>Kondisi</th>
                    <th>Kecamatan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody class="table-border-bottom-0">
                @forelse ($inventaris as $item)
                <tr>
                    <td><strong>{{ $item->kode_inventaris }}</strong></td>
                    <td>
                        <i class="icon-base bx bx-laptop text-info me-2"></i>
                        {{ $item->nama_barang }}
                    </td>
                    <td>{{ $item->kategori }}</td>
                    <td>{{ $item->merk ?? '-' }}{{ $item->tipe ? ' / ' . $item->tipe : '' }}</td>
                    <td>{{ $item->tahun_pengadaan ?? '-' }}</td>
                    <td>{{ $item->jumlah }}</td>
                    <td>
                        @if($item->kondisi === 'baik')
                            <span class="badge bg-success">Baik</span>
                        @elseif($item->kondisi === 'rusak ringan')
                            <span class="badge bg-warning">Rusak Ringan</span>
                        @else
                            <span class="badge bg-danger">Rusak Berat</span>
                        @endif
                    </td>
                    <td>{{ $item->kecamatan?->nama_kecamatan ?? '-' }}</td>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <button type="button" class="btn btn-sm btn-icon btn-outline-warning" data-bs-toggle="modal" data-bs-target="#modalEdit{{ $item->id_inventaris }}" title="Edit">
                                <i class="bx bx-edit-alt"></i>
                            </button>
                            <form action="{{ route('admin.inventaris.destroy', $item->id_inventaris) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus inventaris ini?');">
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
                    <td colspan="8" class="text-center">Data inventaris belum tersedia atau tidak ditemukan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($inventaris->hasPages())
    <div class="card-footer d-flex justify-content-end">
        {{ $inventaris->withQueryString()->links('pagination::bootstrap-5') }}
    </div>
    @endif
</div>

@foreach ($inventaris as $item)
<div class="modal fade" id="modalEdit{{ $item->id_inventaris }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Data Inventaris</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formEdit{{ $item->id_inventaris }}" action="{{ route('admin.inventaris.update', $item->id_inventaris) }}" method="POST" novalidate>
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Kecamatan <span class="text-danger">*</span></label>
                            <select name="id_kecamatan" class="form-select @error('id_kecamatan') is-invalid @enderror" required>
                                <option value="">-- Pilih Kecamatan --</option>
                                @foreach($kecamatan as $kec)
                                <option value="{{ $kec->id_kecamatan }}" {{ $item->id_kecamatan == $kec->id_kecamatan ? 'selected' : '' }}>
                                    {{ $kec->nama_kecamatan }}
                                </option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback">
                                @error('id_kecamatan') {{ $message }} @else Kecamatan wajib dipilih. @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Kode Inventaris <span class="text-danger">*</span></label>
                            <input type="text" name="kode_inventaris" class="form-control bg-light @error('kode_inventaris') is-invalid @enderror" value="{{ $item->kode_inventaris }}" placeholder="Contoh: INV-TIK-001" readonly required />
                            <div class="invalid-feedback">
                                @error('kode_inventaris') {{ $message }} @else Kode inventaris wajib diisi. @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Nama Barang <span class="text-danger">*</span></label>
                            <input type="text" name="nama_barang" class="form-control @error('nama_barang') is-invalid @enderror" value="{{ $item->nama_barang }}" placeholder="Nama barang" required />
                            <div class="invalid-feedback">
                                @error('nama_barang') {{ $message }} @else Nama barang wajib diisi. @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Kategori <span class="text-danger">*</span></label>
                            <input type="text" name="kategori" class="form-control @error('kategori') is-invalid @enderror" value="{{ $item->kategori }}" placeholder="Contoh: Elektronik" required />
                            <div class="invalid-feedback">
                                @error('kategori') {{ $message }} @else Kategori wajib diisi. @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Merk</label>
                            <input type="text" name="merk" class="form-control @error('merk') is-invalid @enderror" value="{{ $item->merk }}" placeholder="Contoh: Lenovo" />
                            @error('merk') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Tipe</label>
                            <input type="text" name="tipe" class="form-control @error('tipe') is-invalid @enderror" value="{{ $item->tipe }}" placeholder="Contoh: ThinkPad X1" />
                            @error('tipe') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Tahun Pengadaan</label>
                            <input type="number" name="tahun_pengadaan" class="form-control @error('tahun_pengadaan') is-invalid @enderror" value="{{ $item->tahun_pengadaan }}" placeholder="Contoh: 2023" min="1900" max="{{ date('Y') }}" />
                            @error('tahun_pengadaan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Jumlah <span class="text-danger">*</span></label>
                            <input type="number" name="jumlah" class="form-control @error('jumlah') is-invalid @enderror" value="{{ $item->jumlah }}" placeholder="Jumlah barang" min="1" required />
                            <div class="invalid-feedback">
                                @error('jumlah') {{ $message }} @else Jumlah wajib diisi. @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label class="form-label">Kondisi <span class="text-danger">*</span></label>
                            <select name="kondisi" class="form-select @error('kondisi') is-invalid @enderror" required>
                                <option value="">-- Pilih Kondisi --</option>
                                <option value="baik" {{ $item->kondisi === 'baik' ? 'selected' : '' }}>Baik</option>
                                <option value="rusak ringan" {{ $item->kondisi === 'rusak ringan' ? 'selected' : '' }}>Rusak Ringan</option>
                                <option value="rusak berat" {{ $item->kondisi === 'rusak berat' ? 'selected' : '' }}>Rusak Berat</option>
                            </select>
                            <div class="invalid-feedback">
                                @error('kondisi') {{ $message }} @else Kondisi wajib dipilih. @enderror
                            </div>
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
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Inventaris Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formTambah" action="{{ route('admin.inventaris.store') }}" method="POST" novalidate>
                @csrf
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="kecamatan_tambah" class="form-label">Kecamatan <span class="text-danger">*</span></label>
                            <select id="kecamatan_tambah" name="id_kecamatan" class="form-select @error('id_kecamatan') is-invalid @enderror" required>
                                <option value="">-- Pilih Kecamatan --</option>
                                @foreach($kecamatan as $kec)
                                <option value="{{ $kec->id_kecamatan }}" {{ old('id_kecamatan') == $kec->id_kecamatan ? 'selected' : '' }}>
                                    {{ $kec->nama_kecamatan }}
                                </option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback">
                                @error('id_kecamatan') {{ $message }} @else Kecamatan wajib dipilih. @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Kode Inventaris <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-light">INV-TIK-</span>
                                <input type="text" class="form-control bg-light" id="kode_preview" value="[Otomatis]" disabled readonly>
                            </div>
                            <small class="text-muted">Kode akan digenerate otomatis oleh sistem</small>
                            <input type="hidden" name="kode_inventaris" id="kode_inventaris" value="">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="nama_tambah" class="form-label">Nama Barang <span class="text-danger">*</span></label>
                            <input type="text" id="nama_tambah" name="nama_barang" class="form-control @error('nama_barang') is-invalid @enderror" value="{{ old('nama_barang') }}" placeholder="Nama barang" required />
                            <div class="invalid-feedback">
                                @error('nama_barang') {{ $message }} @else Nama barang wajib diisi. @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="kategori_tambah" class="form-label">Kategori <span class="text-danger">*</span></label>
                            <input type="text" id="kategori_tambah" name="kategori" class="form-control @error('kategori') is-invalid @enderror" value="{{ old('kategori') }}" placeholder="Contoh: Elektronik" required />
                            <div class="invalid-feedback">
                                @error('kategori') {{ $message }} @else Kategori wajib diisi. @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="merk_tambah" class="form-label">Merk</label>
                            <input type="text" id="merk_tambah" name="merk" class="form-control @error('merk') is-invalid @enderror" value="{{ old('merk') }}" placeholder="Contoh: Lenovo" />
                            @error('merk') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="tipe_tambah" class="form-label">Tipe</label>
                            <input type="text" id="tipe_tambah" name="tipe" class="form-control @error('tipe') is-invalid @enderror" value="{{ old('tipe') }}" placeholder="Contoh: ThinkPad X1" />
                            @error('tipe') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="tahun_tambah" class="form-label">Tahun Pengadaan</label>
                            <input type="number" id="tahun_tambah" name="tahun_pengadaan" class="form-control @error('tahun_pengadaan') is-invalid @enderror" value="{{ old('tahun_pengadaan') }}" placeholder="Contoh: 2023" min="1900" max="{{ date('Y') }}" />
                            @error('tahun_pengadaan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="jumlah_tambah" class="form-label">Jumlah <span class="text-danger">*</span></label>
                            <input type="number" id="jumlah_tambah" name="jumlah" class="form-control @error('jumlah') is-invalid @enderror" value="{{ old('jumlah', 1) }}" placeholder="Jumlah barang" min="1" required />
                            <div class="invalid-feedback">
                                @error('jumlah') {{ $message }} @else Jumlah wajib diisi. @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="kondisi_tambah" class="form-label">Kondisi <span class="text-danger">*</span></label>
                            <select id="kondisi_tambah" name="kondisi" class="form-select @error('kondisi') is-invalid @enderror" required>
                                <option value="">-- Pilih Kondisi --</option>
                                <option value="baik" {{ old('kondisi') === 'baik' ? 'selected' : '' }}>Baik</option>
                                <option value="rusak ringan" {{ old('kondisi') === 'rusak ringan' ? 'selected' : '' }}>Rusak Ringan</option>
                                <option value="rusak berat" {{ old('kondisi') === 'rusak berat' ? 'selected' : '' }}>Rusak Berat</option>
                            </select>
                            <div class="invalid-feedback">
                                @error('kondisi') {{ $message }} @else Kondisi wajib dipilih. @enderror
                            </div>
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
    document.addEventListener('DOMContentLoaded', function() {
    fetch('{{ route("admin.inventaris.get-latest-kode") }}')
        .then(response => response.json())
        .then(data => {
            document.getElementById('kode_preview').value = data.kode;
            document.getElementById('kode_inventaris').value = data.kode;
        });
});
</script>
@endpush
