<?php

namespace App\Http\Requests\Kabid;

use Illuminate\Foundation\Http\FormRequest;

class LaporanIndexRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'status' => 'nullable|in:menunggu,disetujui,ditolak,diproses,selesai',
            'search' => 'nullable|string|max:255'
        ];
    }
}
