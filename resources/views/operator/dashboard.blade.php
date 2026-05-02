@extends('layouts.app')

@section('title', 'Dashboard Operator')

@section('content')
<div class="row">
  <!-- Inventaris Sasaran -->
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
            <h6 class="mb-0">Inventaris Wilayah</h6>
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
            <h6 class="mb-0">Laporan Diajukan</h6>
          </div>
        </div>
        <div class="bg-body p-3 mt-3 rounded">
          <div class="mt-3 row align-items-center">
            <div class="col-7">
              <div id="page-views-graph"></div>
            </div>
            <div class="col-5">
              <h5 class="mb-1">{{ number_format($totalLaporan) }}</h5>
              <p class="text-warning mb-0">Total</p>
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

  <!-- Laporan Diproses -->
  <div class="col-md-6 col-xxl-3">
    <div class="card">
      <div class="card-body">
        <div class="d-flex align-items-center">
          <div class="flex-shrink-0">
            <div class="avtar avtar-s bg-light-info">
              <i class="ti ti-loader f-20"></i>
            </div>
          </div>
          <div class="flex-grow-1 ms-3">
            <h6 class="mb-0">Sedang Diproses</h6>
          </div>
        </div>
        <div class="bg-body p-3 mt-3 rounded">
          <div class="mt-3 row align-items-center">
            <div class="col-7">
              <div id="download-graph"></div>
            </div>
            <div class="col-5">
              <h5 class="mb-1">{{ number_format($laporanDiproses) }}</h5>
              <p class="text-info mb-0">Proses</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Info Ringkas -->
  <div class="col-lg-12">
    <div class="card">
      <div class="card-body">
        <div class="d-flex align-items-center justify-content-between">
          <h5 class="mb-0">Informasi Wilayah Anda</h5>
        </div>
        <div class="row align-items-center justify-content-center">
          <div class="col-md-6 col-xl-4">
            <div class="mt-3 row align-items-center">
              <div class="col-6">
                <p class="text-muted mb-1">Status Laporan</p>
                <h5 class="mb-0">{{ $laporanMenunggu }}</h5>
                <small class="text-muted">Menunggu Verifikasi</small>
              </div>
              <div class="col-6">
                <div id="total-tasks-graph"></div>
              </div>
            </div>
          </div>
          <div class="col-md-6 col-xl-4">
            <div class="mt-3">
               <p class="text-muted mb-1">Presentase Penyelesaian</p>
               <h5 class="mb-0">
                {{ $totalLaporan > 0 ? round(($laporanSelesai / $totalLaporan) * 100, 1) : 0 }}%
               </h5>
            </div>
          </div>
          <div class="col-md-6 col-xl-4">
            <div class="mt-3 d-grid">
              <a href="{{ route('operator.laporan.index') }}" class="btn btn-primary d-flex align-items-center justify-content-center">
                <i class="ti ti-plus me-2"></i> Tambah Laporan Baru
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
