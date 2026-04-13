<?php

namespace App\Livewire\Invoices;

use App\Models\Invoice;
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

    public function render()
    {
        $this->invoice->refresh();
        
        return view('livewire.invoices.invoice-detail', [
            'invoice'  => $this->invoice->load('client', 'items', 'payments'),
        ]);
    }
}