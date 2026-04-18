<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\StorePaymentRequest;
use App\Http\Resources\Api\V1\PaymentResource;
use App\Models\Invoice;
use App\Models\Payment;

class PaymentController extends Controller
{
    public function store(StorePaymentRequest $request, Invoice $invoice)
    {
        $this->authorize('recordPayment', $invoice);

        $payment = Payment::create([
            'invoice_id' => $invoice->id,
            'amount' => $request->validated('amount'),
            'payment_date' => $request->validated('payment_date'),
            'method' => $request->validated('method'),
            'notes' => $request->validated('notes'),
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Payment recorded successfully.',
            'data' => new PaymentResource($payment),
        ], 201);
    }
}
