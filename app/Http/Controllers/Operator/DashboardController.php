<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Controller;
use App\Services\DashboardService;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    protected $dashboardService;

    public function __construct(DashboardService $dashboardService)
    {
        $this->dashboardService = $dashboardService;
    }

    public function index()
    {
        $idKecamatan = Auth::user()->id_kecamatan;
        $stats = $this->dashboardService->getOperatorStats($idKecamatan);

        return view('operator.dashboard', $stats);
    }
}
