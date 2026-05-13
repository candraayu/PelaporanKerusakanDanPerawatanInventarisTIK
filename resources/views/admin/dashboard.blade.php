@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="row">
    <div class="col-12 mb-4">
        <div class="card welcome-card bg-primary text-white overflow-hidden" style="border: none; border-radius: 15px; box-shadow: 0 10px 20px rgba(0,0,0,0.1);">
            <div class="card-body p-4 position-relative">
                <div class="row align-items-center">
                    <div class="col-sm-6">
                        <h2 class="text-white fw-bold mb-2">Selamat Datang, {{ Auth::user()->nama }}! 👋</h2>
                        <p class="text-white-50 mb-0">Berikut adalah ringkasan sistem SI-LAPORTIK hari ini. Pantau laporan dan inventaris dengan mudah.</p>
                    </div>
                    <div class="col-sm-6 text-center d-none d-sm-block">
                        <img src="{{ asset('assets/images/user/avatar-2.jpg') }}" alt="User" class="img-fluid rounded-circle border border-4 border-white-50 shadow" style="width: 100px; height: 100px; object-fit: cover;">
                    </div>
                </div>
                <div class="position-absolute top-0 end-0 p-3 opacity-10">
                    <i class="ti ti-chart-pie" style="font-size: 8rem;"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-xxl-3">
        <div class="card border-0 shadow-sm hover-elevate" style="border-radius: 12px; transition: transform 0.3s ease;">
            <div class="card-body">
                <div class="d-flex align-items-center mb-3">
                    <div class="avtar avtar-s bg-light-primary text-primary flex-shrink-0">
                        <i class="ti ti-package f-24"></i>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <h6 class="text-muted mb-0">Total Inventaris</h6>
                    </div>
                </div>
                <div class="d-flex align-items-baseline">
                    <h3 class="mb-0 fw-bold">{{ number_format($totalInventaris) }}</h3>
                    <span class="ms-2 text-primary font-weight-medium">Unit</span>
                </div>
                <div class="progress mt-3" style="height: 6px;">
                    <div class="progress-bar bg-primary" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-xxl-3">
        <div class="card border-0 shadow-sm hover-elevate" style="border-radius: 12px; transition: transform 0.3s ease;">
            <div class="card-body">
                <div class="d-flex align-items-center mb-3">
                    <div class="avtar avtar-s bg-light-warning text-warning flex-shrink-0">
                        <i class="ti ti-file-description f-24"></i>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <h6 class="text-muted mb-0">Total Laporan</h6>
                    </div>
                </div>
                <div class="d-flex align-items-baseline">
                    <h3 class="mb-0 fw-bold">{{ number_format($totalLaporan) }}</h3>
                    <span class="ms-2 text-warning font-weight-medium">Masuk</span>
                </div>
                <div class="progress mt-3" style="height: 6px;">
                    <div class="progress-bar bg-warning" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-xxl-3">
        <div class="card border-0 shadow-sm hover-elevate" style="border-radius: 12px; transition: transform 0.3s ease;">
            <div class="card-body">
                <div class="d-flex align-items-center mb-3">
                    <div class="avtar avtar-s bg-light-success text-success flex-shrink-0">
                        <i class="ti ti-circle-check f-24"></i>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <h6 class="text-muted mb-0">Laporan Selesai</h6>
                    </div>
                </div>
                <div class="d-flex align-items-baseline">
                    <h3 class="mb-0 fw-bold">{{ number_format($laporanSelesai) }}</h3>
                    <span class="ms-2 text-success font-weight-medium">
                        {{ $totalLaporan > 0 ? round(($laporanSelesai / $totalLaporan) * 100, 1) : 0 }}%
                    </span>
                </div>
                <div class="progress mt-3" style="height: 6px;">
                    <div class="progress-bar bg-success" role="progressbar"style="width: {{ $totalLaporan > 0 ? ($laporanSelesai / $totalLaporan) * 100 : 0 }}%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-xxl-3">
        <div class="card border-0 shadow-sm hover-elevate" style="border-radius: 12px; transition: transform 0.3s ease;">
            <div class="card-body">
                <div class="d-flex align-items-center mb-3">
                    <div class="avtar avtar-s bg-light-danger text-danger flex-shrink-0">
                        <i class="ti ti-loader f-24"></i>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <h6 class="text-muted mb-0">Laporan DiProses</h6>
                    </div>
                </div>
                <div class="d-flex align-items-baseline">
                    <h3 class="mb-0 fw-bold">{{ number_format($laporanDiproses) }}</h3>
                    <span class="ms-2 text-danger font-weight-medium">DiProses</span>
                </div>
                <div class="progress mt-3" style="height: 6px;">
                    <div class="progress-bar bg-danger" role="progressbar"style="width: {{ $totalLaporan > 0 ? ($laporanDiproses / $totalLaporan) * 100 : 0 }}%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm" style="border-radius: 12px;">
            <div class="card-header bg-transparent border-0 pt-4 px-4 d-flex align-items-center justify-content-between">
                <h5 class="mb-0 fw-bold">Tren Laporan Kerusakan</h5>
                <div class="dropdown">
                    <button class="btn btn-sm btn-light dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        {{ $period }} Bulan Terakhir
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item {{ $period == 6 ? 'active' : '' }}" href="{{ route('admin.dashboard', ['period' => 6]) }}">6 Bulan Terakhir</a></li>
                        <li><a class="dropdown-item {{ $period == 12 ? 'active' : '' }}" href="{{ route('admin.dashboard', ['period' => 12]) }}">12 Bulan Terakhir</a></li>
                    </ul>
                </div>
            </div>
            <div class="card-body">
                <div id="reports-trend-chart"></div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card border-0 shadow-sm" style="border-radius: 12px;">
            <div class="card-header bg-transparent border-0 pt-4 px-4">
                <h5 class="mb-0 fw-bold">Status Laporan</h5>
            </div>
            <div class="card-body">
                <div id="report-status-pie"></div>
                <div class="mt-4">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <div class="d-flex align-items-center">
                            <span class="badge bg-success bullet me-2"></span>
                            <span class="text-muted">Selesai</span>
                        </div>
                        <span class="fw-bold">{{ $laporanSelesai }}</span>
                    </div>
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <div class="d-flex align-items-center">
                            <span class="badge bg-danger bullet me-2"></span>
                            <span class="text-muted">Ditolak</span>
                        </div>
                        <span class="fw-bold">{{ $laporanDitolak }}</span>
                    </div>
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <div class="d-flex align-items-center">
                            <span class="badge bg-warning bullet me-2"></span>
                            <span class="text-muted">Diproses</span>
                        </div>
                        <span class="fw-bold">{{ $laporanDiproses }}</span>
                    </div>
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <div class="d-flex align-items-center">
                            <span class="badge bg-info bullet me-2"></span>
                            <span class="text-muted">Disetujui</span>
                        </div>
                        <span class="fw-bold">{{ $laporanDisetujui }}</span>
                    </div>

                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <div class="d-flex align-items-center">
                            <span class="badge bg-secondary bullet me-2"></span>
                            <span class="text-muted">Menunggu</span>
                        </div>
                        <span class="fw-bold">{{ $laporanMenunggu }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12">
        <div class="card border-0 shadow-sm" style="border-radius: 12px;">
            <div class="card-header bg-transparent border-0 pt-4 px-4 d-flex align-items-center justify-content-between">
                <h5 class="mb-0 fw-bold">Laporan Terbaru</h5>
                <a href="{{ route('admin.laporan.index') }}" class="btn btn-sm btn-primary">Lihat Semua</a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0 align-middle">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-4 border-0">KODE</th>
                                <th class="border-0">INVENTARIS</th>
                                <th class="border-0">OPERATOR</th>
                                <th class="border-0">TANGGAL</th>
                                <th class="border-0 text-center">STATUS</th>
                                <th class="border-0 text-end pe-4">AKSI</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentLaporan as $laporan)
                            <tr>
                                <td class="ps-4 fw-medium text-primary">{{ $laporan->id_laporan }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="bg-light p-2 rounded me-3">
                                            <i class="ti ti-device-laptop text-muted"></i>
                                        </div>
                                        <div>
                                            <p class="mb-0 fw-bold text-dark">{{ $laporan->inventaris->nama_barang }}</p>
                                            <small class="text-muted">{{ $laporan->inventaris->kode_barang }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $laporan->user->nama ?? '-' }}</td>
                                <td>{{ \Carbon\Carbon::parse($laporan->tanggal_laporan)->format('d M Y') }}</td>
                                <td class="text-center">
                                    @php
                                        $badgeClass = 'bg-light-secondary';
                                        if($laporan->status == 'selesai') $badgeClass = 'bg-info';
                                        elseif($laporan->status == 'diproses') $badgeClass = 'bg-warning';
                                    @endphp
                                    <span class="badge {{ $badgeClass }} px-3 py-2 text-uppercase" style="font-size: 10px;">{{ $laporan->status }}</span>
                                </td>
                                <td class="text-end pe-4">
                                    <a href="{{ route('admin.laporan.show', $laporan->id_laporan) }}" class="btn btn-icon btn-sm btn-light-primary">
                                        <i class="ti ti-eye"></i>
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center py-4 text-muted">Belum ada laporan kerusakan.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .hover-elevate:hover {
        transform: translateY(-5px);
        box-shadow: 0 1rem 3rem rgba(0,0,0,.1) !important;
    }
    .bullet {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        display: inline-block;
    }
</style>
@endsection

@push('scripts')
<script src="{{ asset('assets/js/plugins/apexcharts.min.js') }}"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var trendOptions = {
            series: [{
                name: 'Total Laporan',
                data: @json($reportCounts)
            }, {
                name: 'Laporan Selesai',
                data: @json($completedCounts)
            }],
            chart: {
                height: 350,
                type: 'area',
                toolbar: { show: false },
                fontFamily: 'Inter, sans-serif'
            },
            colors: ['#3f51b5', '#4caf50'],
            dataLabels: { enabled: false },
            stroke: { curve: 'smooth', width: 3 },
            fill: {
                type: 'gradient',
                gradient: {
                    shadeIntensity: 1,
                    opacityFrom: 0.4,
                    opacityTo: 0.1,
                    stops: [0, 90, 100]
                }
            },
            xaxis: {
                categories: @json($months),
                axisBorder: { show: false },
                axisTicks: { show: false }
            },
            yaxis: {
                labels: {
                    formatter: function (val) { return val.toFixed(0); }
                }
            },
            grid: {
                borderColor: '#f1f1f1',
                padding: { top: 0, right: 0, bottom: 0, left: 10 }
            },
            legend: { position: 'top', horizontalAlign: 'right' }
        };

        var trendChart = new ApexCharts(document.querySelector("#reports-trend-chart"), trendOptions);
        trendChart.render();
        var statusOptions = {
            series: [
                {{ $laporanSelesai }},
                {{ $laporanDiproses }},
                {{ $laporanDitolak }},
                {{ $laporanDisetujui }},
                {{ $laporanMenunggu }}
            ],
            chart: {
                type: 'donut',
                height: 250
            },
            labels: ['Selesai', 'Diproses', 'Ditolak', 'Disetujui', 'Menunggu'],
            colors: ['#4caf50', '#ffc107', '#dc3545', '#0dcaf0', '#6c757d'],
            legend: { show: false },
            dataLabels: { enabled: false },
            plotOptions: {
                pie: {
                    donut: {
                        size: '75%',
                        labels: {
                            show: true,
                            total: {
                                show: true,
                                label: 'Total',
                                formatter: function (w) { return {{ $totalLaporan }}; }
                            }
                        }
                    }
                }
            }
        };
        var statusChart = new ApexCharts(document.querySelector("#report-status-pie"), statusOptions);
        statusChart.render();
    });
</script>
@endpush
