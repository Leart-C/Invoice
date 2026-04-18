<?php

namespace App\Http\Requests\Api\V1;

use Illuminate\Foundation\Http\FormRequest;

class StorePaymentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $invoice = $this->route('invoice');

        return [
            'amount' => [
                'required',
                'numeric',
                'min:0.01',
                'max:' . $invoice->remaining_balance,
            ],
            'payment_date' => 'required|date',
            'method' => 'required|in:cash,bank_transfer,card,other',
            'notes' => 'nullable|string|max:500',
        ];
    }

    public function messages(): array
    {
        $invoice = $this->route('invoice');

        return [
            'amount.max' => 'Payment cannot exceed the remaining balance of $' . number_format($invoice->remaining_balance, 2),
        ];
    }
}