<?php

namespace App\Http\Controllers\Kabid;

use App\Http\Controllers\Controller;
use App\Http\Requests\Kabid\MonitoringIndexRequest;
use App\Services\KecamatanService;

class MonitoringKecamatanController extends Controller
{
    protected $kecamatanService;

    public function __construct(KecamatanService $kecamatanService)
    {
        $this->kecamatanService = $kecamatanService;
    }

    public function index(MonitoringIndexRequest $request)
    {
        $kecamatan = $this->kecamatanService->getAll($request->validated());
        return view('kabid.kecamatan', compact('kecamatan'));
    }
}
