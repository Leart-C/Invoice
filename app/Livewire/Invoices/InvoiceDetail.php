<?php

namespace App\Livewire\Invoices;

use App\Mail\InvoiceMail;
use App\Models\Invoice;
use App\Services\InvoicePdfService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;

class InvoiceDetail extends Component
{
    public Invoice $invoice;

    public function mount(Invoice $invoice): void
    {
        $this->invoice = $invoice;
    }

    public function markAsSent(): void
    {
        $this->invoice->markAsSent();
        $this->invoice->refresh();
        session()->flash('success', 'Invoice marked as sent.');
    }

    public function sendInvoice():void
    {
        if(Auth::user()->role === 'viewer'){
            session()->flash('error','You do not have permission to send invoices.');
            return;
        }

        $pdfService = app(InvoicePdfService::class);

        Mail::to($this->invoice->client->email)
            ->send(new InvoiceMail($this->invoice,$pdfService));

        if($this->invoice->status === 'draft'){
            $this->invoice->markAsSent();
        }

        $this->invoice->refresh();

        session()->flash('success','Invoice sent to '. $this->invoice->client->email);
    }

    public function render()
    {
        $this->invoice->refresh();
        
        return view('livewire.invoices.invoice-detail', [
            'invoice'  => $this->invoice->load('client', 'items', 'payments'),
        ]);
    }
}