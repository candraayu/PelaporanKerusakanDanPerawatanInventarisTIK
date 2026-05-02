<?php

namespace App\Http\Requests\Kabid;

use Illuminate\Foundation\Http\FormRequest;

class MonitoringIndexRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'search' => 'nullable|string|max:255'
        ];
    }
}
