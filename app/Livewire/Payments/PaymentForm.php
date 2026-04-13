<?php

namespace App\Livewire\Payments;

use App\Models\Invoice;
use App\Models\Payment;
use Livewire\Component;

class PaymentForm extends Component
{
    public Invoice $invoice;

    public float  $amount = 0;
    public string $payment_date = '';
    public string $method = 'cash';
    public string $notes = '';

    public function mount(Invoice $invoice): void
    {
        $this->invoice = $invoice;
        $this->payment_date = now()->format('Y-m-d');
        $this->amount = round($invoice->remaining_balance, 2);
    }

    protected function rules(): array
    {
        return [
            'amount' => [
                'required',
                'numeric',
                'min:0.01',
                'max:' . $this->invoice->remaining_balance,
            ],
            'payment_date' => 'required|date',
            'method' => 'required|in:cash,bank_transfer,card,other',
            'notes' => 'nullable|string|max:500',
        ];
    }

    protected function messages(): array
    {
        return [
            'amount.max' => 'Payment cannot exceed the remaining balance of $' . number_format($this->invoice->remaining_balance, 2),
        ];
    }

    public function save(): void
    {
        $this->validate();

        Payment::create([
            'invoice_id' => $this->invoice->id,
            'amount' => $this->amount,
            'payment_date' => $this->payment_date,
            'method' => $this->method,
            'notes' => $this->notes,
        ]);

        session()->flash('success', 'Payment recorded successfully.');
        $this->redirect(route('invoices.show', $this->invoice));
    }

    public function render()
    {
        return view('livewire.payments.payment-form');
    }
}