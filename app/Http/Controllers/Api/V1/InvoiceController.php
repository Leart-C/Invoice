<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\FilterInvoicesRequest;
use App\Http\Resources\Api\V1\InvoiceDetailResource;
use App\Http\Resources\Api\V1\InvoiceResource;
use App\Models\Invoice;

class InvoiceController extends Controller
{
    public function index(FilterInvoicesRequest $request){
        $filters = $request->validated();

        $invoices = Invoice::with('client')
            ->filter($filters)
            ->latest()
            ->paginate(15)
            ->appends($filters);

        return response()->json([
            'status' => 'success',
            'message' => 'Invoices retrieved successfully.',
            'data' => InvoiceResource::collection($invoices),
        ]);
    }

    public function show(Invoice $invoice)
    {
        $invoice->load(['client', 'items', 'payments']);

        return response()->json([
            'status' => 'success',
            'message' => 'Invoice retrieved successfully.',
            'data' => new InvoiceDetailResource($invoice),
        ]);
    }
}