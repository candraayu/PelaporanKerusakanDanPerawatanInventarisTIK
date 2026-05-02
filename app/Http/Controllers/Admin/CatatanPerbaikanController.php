<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CatatanStoreRequest;
use App\Services\CatatanService;

class CatatanPerbaikanController extends Controller
{
    protected $catatanService;

    public function __construct(CatatanService $catatanService)
    {
        $this->catatanService = $catatanService;
    }

    public function store(CatatanStoreRequest $request)
    {
        $this->catatanService->create($request->validated());
        return back();
    }
}
