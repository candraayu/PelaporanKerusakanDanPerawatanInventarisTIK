<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class CatatanStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'id_laporan' => 'required|exists:laporan_kerusakan,id_laporan',
            'catatan' => 'required|string',
            'tanggal' => 'required|date'
        ];
    }
}
