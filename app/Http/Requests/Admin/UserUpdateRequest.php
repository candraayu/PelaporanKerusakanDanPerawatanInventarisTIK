<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('user');
        return [
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id . ',id_user',
            'id_kecamatan' => 'nullable|exists:kecamatan,id_kecamatan',
            'password' => 'nullable|min:6'
        ];
    }
}
