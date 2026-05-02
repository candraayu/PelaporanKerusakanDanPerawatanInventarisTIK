<?php

namespace App\Http\Controllers\Kabid;

use App\Http\Controllers\Controller;
use App\Services\DashboardService;

class DashboardController extends Controller
{
    protected $dashboardService;

    public function __construct(DashboardService $dashboardService)
    {
        $this->dashboardService = $dashboardService;
    }

    public function index()
    {
        $stats = $this->dashboardService->getKabidStats();
        return view('kabid.dashboard', $stats);
    }
}
