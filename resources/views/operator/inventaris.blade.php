@extends('layouts.app')

@section('title', 'Data Inventaris')

@section('content')
<div class="row mb-4">
    <div class="col-12 d-flex justify-content-between align-items-center">
        <h4 class="fw-bold py-3 mb-0"> Data Inventaris</h4>
        <div class="d-flex gap-2">
            <form action="{{ route('operator.inventaris.index') }}" method="GET" class="d-flex">
                <input type="text" name="search" class="form-control me-2" placeholder="Cari nama barang..." value="{{ request('search') }}">
                <button type="submit" class="btn btn-outline-primary"><i class="bx bx-search"></i></button>
            </form>
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
                    <th>Kode</th>
                    <th>Nama Barang</th>
                    <th>Kategori</th>
                    <th>Merk / Tipe</th>
                    <th>Tahun</th>
                    <th>Kondisi</th>
                    <th>Kecamatan</th>
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

                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center">Data inventaris belum tersedia.</td>
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

        @if($errors->any())
        var myModal = new bootstrap.Modal(document.getElementById('modalTambah'));
        myModal.show();
        @endif
    });
</script>
@endpush
