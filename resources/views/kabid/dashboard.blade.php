@extends('layouts.app')

@section('title', 'Dashboard Kabid')

@section('content')
<div class="row">
  <!-- Total Inventaris -->
  <div class="col-md-6 col-xxl-3">
    <div class="card">
      <div class="card-body">
        <div class="d-flex align-items-center">
          <div class="flex-shrink-0">
            <div class="avtar avtar-s bg-light-primary">
              <i class="ti ti-package f-20"></i>
            </div>
          </div>
          <div class="flex-grow-1 ms-3">
            <h6 class="mb-0">Total Inventaris</h6>
          </div>
        </div>
        <div class="bg-body p-3 mt-3 rounded">
          <div class="mt-3 row align-items-center">
            <div class="col-7">
              <div id="all-earnings-graph"></div>
            </div>
            <div class="col-5">
              <h5 class="mb-1">{{ number_format($totalInventaris) }}</h5>
              <p class="text-primary mb-0">Unit</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Total Laporan Kerusakan -->
  <div class="col-md-6 col-xxl-3">
    <div class="card">
      <div class="card-body">
        <div class="d-flex align-items-center">
          <div class="flex-shrink-0">
            <div class="avtar avtar-s bg-light-warning">
              <i class="ti ti-file-description f-20"></i>
            </div>
          </div>
          <div class="flex-grow-1 ms-3">
            <h6 class="mb-0">Total Laporan</h6>
          </div>
        </div>
        <div class="bg-body p-3 mt-3 rounded">
          <div class="mt-3 row align-items-center">
            <div class="col-7">
              <div id="page-views-graph"></div>
            </div>
            <div class="col-5">
              <h5 class="mb-1">{{ number_format($totalLaporan) }}</h5>
              <p class="text-warning mb-0">Masuk</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Laporan Selesai -->
  <div class="col-md-6 col-xxl-3">
    <div class="card">
      <div class="card-body">
        <div class="d-flex align-items-center">
          <div class="flex-shrink-0">
            <div class="avtar avtar-s bg-light-success">
              <i class="ti ti-circle-check f-20"></i>
            </div>
          </div>
          <div class="flex-grow-1 ms-3">
            <h6 class="mb-0">Laporan Selesai</h6>
          </div>
        </div>
        <div class="bg-body p-3 mt-3 rounded">
          <div class="mt-3 row align-items-center">
            <div class="col-7">
              <div id="total-task-graph"></div>
            </div>
            <div class="col-5">
              <h5 class="mb-1">{{ number_format($laporanSelesai) }}</h5>
              <p class="text-success mb-0">Tuntas</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Menunggu Persetujuan -->
  <div class="col-md-6 col-xxl-3">
    <div class="card">
      <div class="card-body">
        <div class="d-flex align-items-center">
          <div class="flex-shrink-0">
            <div class="avtar avtar-s bg-light-danger">
              <i class="ti ti-loader f-20"></i>
            </div>
          </div>
          <div class="flex-grow-1 ms-3">
            <h6 class="mb-0">Perlu Persetujuan</h6>
          </div>
        </div>
        <div class="bg-body p-3 mt-3 rounded">
          <div class="mt-3 row align-items-center">
            <div class="col-7">
              <div id="download-graph"></div>
            </div>
            <div class="col-5">
              <h5 class="mb-1">{{ number_format($laporanMenunggu) }}</h5>
              <p class="text-danger mb-0">Antrean</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Monitoring Wilayah -->
  <div class="col-lg-12">
    <div class="card">
      <div class="card-body">
        <div class="d-flex align-items-center justify-content-between">
          <h5 class="mb-0">Monitoring Wilayah</h5>
        </div>
        <div class="row align-items-center justify-content-center">
          <div class="col-md-6 col-xl-4">
            <div class="mt-3 row align-items-center">
              <div class="col-6">
                <p class="text-muted mb-1">Kecamatan Terdata</p>
                <h5 class="mb-0">{{ $totalKecamatan }}</h5>
              </div>
              <div class="col-6">
                <div id="total-tasks-graph"></div>
              </div>
            </div>
          </div>
          <div class="col-md-6 col-xl-4">
            <div class="mt-3">
               <p class="text-muted mb-1">Efektivitas Perbaikan</p>
               <h5 class="mb-0">
                {{ $totalLaporan > 0 ? round(($laporanSelesai / $totalLaporan) * 100, 1) : 0 }}%
               </h5>
            </div>
          </div>
          <div class="col-md-6 col-xl-4">
            <div class="mt-3 d-grid">
              <a href="{{ route('kabid.laporan.index') }}" class="btn btn-primary d-flex align-items-center justify-content-center">
                <i class="ti ti-list-details me-2"></i> Kelola Persetujuan
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
