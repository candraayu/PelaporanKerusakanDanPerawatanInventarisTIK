<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\DashboardService;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    protected $dashboardService;

    public function __construct(DashboardService $dashboardService)
    {
        $this->dashboardService = $dashboardService;
    }

    public function index(Request $request)
    {
        $period = $request->get('period', 6);
        if (!in_array($period, [6, 12])) {
            $period = 6;
        }

        $stats = $this->dashboardService->getStats();
        $recentLaporan = $this->dashboardService->getRecentReports();
        $trend = $this->dashboardService->getTrendData($period);

        return view('admin.dashboard', array_merge($stats, $trend, [
            'recentLaporan' => $recentLaporan,
            'period'        => $period,
        ]));
    }
}
