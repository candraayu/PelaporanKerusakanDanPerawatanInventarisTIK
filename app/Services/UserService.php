<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserService
{
    public function getAll(array $filters = [])
    {
        $query = User::with('kecamatan')->where('role', 'operator');

        if (isset($filters['search']) && $filters['search'] != '') {
            $search = $filters['search'];
            $query->where(function($q) use ($search) {
                $q->where('nama', 'LIKE', '%' . $search . '%')
                  ->orWhere('email', 'LIKE', '%' . $search . '%');
            });
        }

        return $query->latest()->paginate(10);
    }

    public function create(array $data): User
    {
        $data['role'] = 'operator';
        $data['password'] = Hash::make($data['password']);
        return User::create($data);
    }

    public function find(int $id): User
    {
        return User::findOrFail($id);
    }

    public function update(int $id, array $data): bool
    {
        $user = $this->find($id);

        if (isset($data['password']) && $data['password']) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        return $user->update($data);
    }

    public function delete(int $id): bool
    {
        $user = $this->find($id);
        return $user->delete();
    }
}
