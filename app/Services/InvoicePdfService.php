<?php

namespace App\Services;

use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Invoice;


class InvoicePdfService
{
    public function generate(Invoice $invoice)
    {
        $data = [
            'invoice' => $invoice,
            'client' => $invoice->client,
            'items' => $invoice->items,
        ];

        return Pdf::loadView('pdf.invoice',$data);
    }

    public function generateRaw(Invoice $invoice): string
    {
        $pdf = Pdf::loadView('pdf.invoice',[
            'invoice' => $invoice->load('client','items'),
        ]);

        return $pdf->output();
    }

    public function stream(Invoice $invoice)
    {
        $pdf = $this->generate($invoice);

        $filename = $this->getFileName($invoice);

        return $pdf->stream($filename);
    }

    public function getFileName(Invoice $invoice)
    {
        return 'INV-' . now()->year . '-' . str_pad($invoice->id,4,'0',STR_PAD_LEFT) . 'pdf';   
    }
}