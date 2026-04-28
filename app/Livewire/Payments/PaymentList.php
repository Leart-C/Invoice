<?php

namespace App\Livewire\Payments;

use App\Models\Payment;
use Livewire\Component;

class PaymentList extends Component
{
    public int  $invoiceId;
    public bool $showDeleteModal = false;
    public ?int $paymentToDelete = null;

    public function mount(int $invoiceId): void
    {
        $this->invoiceId = $invoiceId;
    }

    public function confirmDelete(int $paymentId): void
    {
        $this->paymentToDelete = $paymentId;
        $this->showDeleteModal = true;
    }

    public function cancelDelete(): void
    {
        $this->paymentToDelete = null;
        $this->showDeleteModal = false;
    }

    public function delete(): void
    {
        $payment = Payment::findOrFail($this->paymentToDelete);
        $payment->delete();
        session()->flash('success', 'Payment deleted.');
        $this->cancelDelete();
    }

    public function render()
    {
        return view('livewire.payments.payment-list', [
            'payments' => Payment::where('invoice_id', $this->invoiceId)
                ->latest('payment_date')
                ->get(),
        ]);
    }
}