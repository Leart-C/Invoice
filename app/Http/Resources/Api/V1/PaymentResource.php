<?php

namespace App\Http\Resources\Api\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PaymentResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'amount' => (float) $this->amount,
            'payment_date' => optional($this->payment_date)->format('Y-m-d'),
            'method' => $this->method,
            'notes' => $this->notes,
            'created_at' => optional($this->created_at)->toISOString(),
        ];
    }
}
