<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Services\InvoicePdfService;

class InvoiceController extends Controller
{
    public function download($id,InvoicePdfService $pdfService)
    {
        $invoice = Invoice::findOrFail($id);

        $this->authorize('downloadPdf',$invoice);

        return $pdfService->stream($invoice);
    }
}