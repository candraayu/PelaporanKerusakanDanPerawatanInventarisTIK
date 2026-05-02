<?php

namespace App\Http\Controllers\Kabid;

use App\Http\Controllers\Controller;
use App\Http\Requests\Kabid\MonitoringIndexRequest;
use App\Services\InventarisService;

class MonitoringInventarisController extends Controller
{
    protected $inventarisService;

    public function __construct(InventarisService $inventarisService)
    {
        $this->inventarisService = $inventarisService;
    }

    public function index(MonitoringIndexRequest $request)
    {
        $inventaris = $this->inventarisService->getAll($request->validated());
        return view('kabid.inventaris', compact('inventaris'));
    }
}
