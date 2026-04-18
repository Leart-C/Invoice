<?php

namespace App\Http\Resources\Api\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InvoiceResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'invoice_number' => $this->invoice_number,
            'status' => $this->status,
            'issue_date' => optional($this->issue_date)->format('Y-m-d'),
            'due_date' => optional($this->due_date)->format('Y-m-d'),
            'subtotal' => (float) $this->subtotal,
            'tax' => (float) $this->tax,
            'total' => (float) $this->total,
            'amount_paid' => (float) $this->amount_paid,
            'remaining_balance' => (float) $this->remaining_balance,
            'client' => $this->whenLoaded('client', function () {
                return [
                    'id' => $this->client->id,
                    'name' => $this->client->name,
                    'email' => $this->client->email,
                ];
            }),
            'created_at' => optional($this->created_at)->toISOString(),
        ];
    }
}
