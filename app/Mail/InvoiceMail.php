<?php

namespace App\Mail;

use App\Models\Invoice;
use App\Services\InvoicePdfService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Attachment;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class InvoiceMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public function __construct(public Invoice $invoice, private InvoicePdfService $invoicePdfService)
    {}

    public function envelope():Envelope
    {
        return new Envelope(
            subject:'Invoice '. $this->invoice->invoice_number . ' from Invoice Tracker',
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.invoice',
            with:[
                'invoice' => $this->invoice,
                'client' => $this->invoice->client,
                'invoiceUrl' => url('/invoices/' . $this->invoice->id),
            ]
        );
    }

    public function attachment(): array
    {
        $pdf = $this->invoicePdfService->generateRaw($this->invoice);

        return [
            Attachment::fromData(
                fn() => $pdf,
                $this->invoice->invoice_number . '.pdf'
            )->withMime('application/pdf'),
        ];
    }

}