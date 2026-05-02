<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Operator\OperatorSearchRequest;
use App\Services\PerawatanService;

class PerawatanController extends Controller
{
    protected $perawatanService;

    public function __construct(PerawatanService $perawatanService)
    {
        $this->perawatanService = $perawatanService;
    }

    public function index(OperatorSearchRequest $request)
    {
        // Admin lihat SEMUA data (tidak dibatasi kecamatan)
        $perawatan = $this->perawatanService->getAll($request->validated(), null);

        return view('admin.perawatan', compact('perawatan'));
    }

    public function show($id)
    {
        $perawatan = $this->perawatanService->find($id);

        return view('admin.perawatan.show', compact('perawatan'));
    }
}