<?php

namespace App\Livewire\Invoices;

use App\Models\Client;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use Livewire\Component;

class InvoiceForm extends Component
{
    public ?Invoice $invoice = null;

    public string $client_id = '';
    public string $issue_date = '';
    public string $due_date = '';
    public float  $tax = 0;
    public string $notes = '';
    public string $status = 'draft';

    public array $items = [];

    public function mount(?Invoice $invoice = null): void
    {
        if ($invoice && $invoice->exists) {
            $this->invoice = $invoice;
            $this->client_id = $invoice->client_id;
            $this->issue_date = $invoice->issue_date->format('Y-m-d');
            $this->due_date = $invoice->due_date->format('Y-m-d');
            $this->tax = $invoice->tax;
            $this->notes = $invoice->notes ?? '';
            $this->status = $invoice->status;
            $this->items = $invoice->items->map(fn($i) => [
                'description' => $i->description,
                'quantity' => $i->quantity,
                'unit_price' => $i->unit_price,
                'total' => $i->total,
            ])->toArray();
        } else {
            $this->addItem();
        }
    }

    public function addItem(): void
    {
        $this->items[] =[
            'description'=>'',
            'quantity'=>1,
            'unit_price' =>0,
            'total'=>0,
        ];
    }

    public function updateItems():void
    {
        foreach ($this->items as $i => $item) {
            $this->items[$i]['total'] = round(
                ($item['quantity'] ?? 0) * ($item['unit_price'] ?? 0),
                2
            );
        }
    }

    public function getSubtotalProperty(): float
    {
        return round(array_sum(array_column($this->items, 'total')), 2);
    }

    public function getTaxAmountProperty(): float
    {
        return round($this->subtotal * ($this->tax / 100), 2);
    }

    public function getTotalProperty(): float
    {
        return round($this->subtotal + $this->taxAmount, 2);
    }

    protected function rules(): array
    {
        return [
            'client_id' => 'required|exists:clients,id',
            'issue_date' => 'required|date',
            'due_date' => 'required|date|after_or_equal:issue_date',
            'tax' => 'nullable|numeric|min:0|max:100',
            'notes' => 'nullable|string',
            'items' => 'required|array|min:1',
            'items.*.description' => 'required|string',
            'items.*.quantity' => 'required|numeric|min:0.01',
            'items.*.unit_price' => 'required|numeric|min:0',
        ];
    }

    public function save(): void
    {
        $this->validate();

        $data = [
            'client_id' => $this->client_id,
            'issue_date' => $this->issue_date,
            'due_date' => $this->due_date,
            'tax' => $this->tax,
            'notes' => $this->notes,
            'subtotal' => $this->subtotal,
            'total' => $this->total,
        ];

        if ($this->invoice) {
            $this->invoice->update($data);
            $this->invoice->items()->delete();
            $invoice = $this->invoice;
        } else {
            $data['invoice_number'] = Invoice::generateNumber();
            $data['status'] = 'draft';
            $data['amount_paid'] = 0;
            $invoice = Invoice::create($data);
        }

        foreach ($this->items as $item) {
            $invoice->items()->create([
                'description' => $item['description'],
                'quantity' => $item['quantity'],
                'unit_price' => $item['unit_price'],
                'total' => $item['total'],
            ]);
        }

        session()->flash('success', $this->invoice ? 'Invoice updated.' : 'Invoice created.');
        $this->redirect(route('invoices.index'));
    }

    public function render()
    {
        return view('livewire.invoices.invoice-form', [
            'clients' => Client::orderBy('name')->get(),
        ]);
    }
}