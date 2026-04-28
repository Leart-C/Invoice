<?php

namespace App\Http\Requests\Api\V1;

use Illuminate\Foundation\Http\FormRequest;

class FilterInvoicesRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'status' => 'nullable|in:draft,sent,paid,partial,overdue',
            'client_id' => 'nullable|integer|exists:clients,id',
            'search' => 'nullable|string|max:255',
        ];
    }
}