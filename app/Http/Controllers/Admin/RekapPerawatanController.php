<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\PerawatanService;
use Illuminate\Http\Request;

class RekapPerawatanController extends Controller
{
    protected $service;

    public function __construct(PerawatanService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request)
    {
        $data = $this->service->getRekap($request->all());
        return view('admin.rekap_perawatan.index', compact('data'));
    }

    public function download(Request $request)
    {
        $data = $this->service->getRekap($request->all(), 0);
        return view('admin.rekap_perawatan.download', compact('data'));
    }
}