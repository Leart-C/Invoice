<?php

namespace App\Http\Resources\Api\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ClientDetailResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'address' => $this->address,
            'company_name' => $this->company_name,
            'outstanding_balance' => (float) $this->outstanding_balance,
            'invoices' => InvoiceResource::collection($this->whenLoaded('invoices')),
            'created_at' => optional($this->created_at)->toISOString(),
        ];
    }
}
