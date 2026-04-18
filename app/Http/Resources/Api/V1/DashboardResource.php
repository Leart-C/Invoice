<?php

namespace App\Http\Resources\Api\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DashboardResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'total_revenue' => (float) $this['total_revenue'],
            'outstanding_balance' => (float) $this['outstanding_balance'],
            'overdue_invoices_count' => (int) $this['overdue_invoices_count'],
            'total_clients' => (int) $this['total_clients'],
            'revenue_comparison' => $this['revenue_comparison'],
        ];
    }
}
