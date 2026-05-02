<?php
namespace App\Http\Controllers\Kabid;

use App\Http\Controllers\Controller;
use App\Services\PerawatanService;
use Illuminate\Support\Facades\Auth;
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
        $idKecamatan = Auth::user()->id_kecamatan;
        $data = $this->service->getRekap($request->all(), 10, $idKecamatan);

        return view('kabid.rekap_perawatan.index', compact('data'));
    }

    public function download(Request $request)
    {
        $idKecamatan = Auth::user()->id_kecamatan;
        $data = $this->service->getRekap($request->all(), 0, $idKecamatan);

        return view('kabid.rekap_perawatan.download', compact('data'));
    }
}