<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\DashboardResource;
use App\Services\DashboardMetricsService;

class DashboardController extends Controller
{
    public function index(DashboardMetricsService $service)
    {
        $payload = [
            'total_revenue' => $service->totalRevenue(),
            'outstanding_balance' => $service->outstandingBalance(),
            'overdue_invoices_count' => $service->overdueInvoicesCount(),
            'total_clients' => $service->totalClients(),
            'revenue_comparison' => $service->revenueComparison(),
        ];

        return response()->json([
            'status' => 'success',
            'message' => 'Dashboard metrics retrieved successfully.',
            'data' => new DashboardResource($payload),
        ]);
    }
}
