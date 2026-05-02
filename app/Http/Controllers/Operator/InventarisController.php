<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Controller;
use App\Http\Requests\Operator\OperatorSearchRequest;
use App\Services\InventarisService;
use Illuminate\Support\Facades\Auth;

class InventarisController extends Controller
{
    protected $inventarisService;

    public function __construct(InventarisService $inventarisService)
    {
        $this->inventarisService = $inventarisService;
    }

    public function index(OperatorSearchRequest $request)
    {
        $idKecamatan = Auth::user()->id_kecamatan;
        $inventaris = $this->inventarisService->getAll($request->validated(), $idKecamatan);

        return view('operator.inventaris', compact('inventaris'));
    }
}
