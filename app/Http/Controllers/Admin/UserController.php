<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UserStoreRequest;
use App\Http\Requests\Admin\UserUpdateRequest;
use App\Services\UserService;
use App\Models\Kecamatan;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index(Request $request)
    {
        $users = $this->userService->getAll($request->all());
        $kecamatan = Kecamatan::all();
        return view('admin.users', compact('users', 'kecamatan'));
    }

    public function create()
    {
        $kecamatan = Kecamatan::all();
        return view('admin.users.create', compact('kecamatan'));
    }

    public function store(UserStoreRequest $request)
    {
        $this->userService->create($request->validated());
        return redirect()->route('admin.users.index');
    }

    public function show($id)
    {
        $user = $this->userService->find($id)->load('kecamatan');
        return view('admin.users.show', compact('user'));
    }

    public function edit($id)
    {
        $user = $this->userService->find($id);
        $kecamatan = Kecamatan::all();
        return view('admin.users.edit', compact('user', 'kecamatan'));
    }

    public function update(UserUpdateRequest $request, $id)
    {
        $this->userService->update($id, $request->validated());
        return redirect()->route('admin.users.index');
    }

    public function destroy($id)
    {
        $this->userService->delete($id);
        return redirect()->route('admin.users.index');
    }
}
