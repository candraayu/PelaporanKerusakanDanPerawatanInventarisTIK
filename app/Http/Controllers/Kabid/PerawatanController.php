<?php

namespace App\Http\Controllers\Kabid;

use App\Http\Controllers\Controller;
use App\Http\Requests\Operator\OperatorSearchRequest;
use App\Services\PerawatanService;
use Illuminate\Support\Facades\Auth;

class PerawatanController extends Controller
{
    protected $perawatanService;

    public function __construct(PerawatanService $perawatanService)
    {
        $this->perawatanService = $perawatanService;
    }

    public function index(OperatorSearchRequest $request)
    {
        $idKecamatan = Auth::user()->id_kecamatan;

        $perawatan = $this->perawatanService->getAll($request->validated(), $idKecamatan);

        return view('kabid.perawatan', compact('perawatan'));
    }

    public function show($id)
    {
        $perawatan = $this->perawatanService->find($id);

        return view('kabid.perawatan.show', compact('perawatan'));
    }
}