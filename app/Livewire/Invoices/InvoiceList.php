<?php

namespace App\Livewire\Invoices;

use App\Models\Client;
use App\Models\Invoice;
use Livewire\Component;
use Livewire\WithPagination;

class InvoiceList extends Component
{
    use WithPagination;

    public string $search = '';
    public string $status = '';
    public string $client_id = '';

    public bool $showDeleteModal = false;
    public ?int $invoiceToDelete = null;

    public function updateSearch(): void {$this->resetPage();}
    public function updateStatus(): void {$this->resetPage();}
    public function updateClientId(): void {$this->resetPage();}

    public function confirmDelete(int $id):void
    {
        $invoice = Invoice::findOrFail($id);

        if(!$invoice->canBeDeleted()){
            session()->flash('error','Only draft invoices can be deleted.');
            return;
        }

        $this->invoiceToDelete = $id;
        $this->showDeleteModal = true;
    }

    public function delete():void
    {
        $invoice = Invoice::findOrFail($this->invoiceToDelete);
        $invoice->delete();
        session()->flash('success','Invoice deleted');
        $this->showDeleteModal = false;
        $this->invoiceToDelete = null;
    }

    public function markAsSent(int $id): void
    {
        $invoice = Invoice::findOrFail($id);
        $invoice->markAsSent();
        session()->flash('success','Invoice marked as sent.');
    }

    public function render()
    {
        return view('livewire.invoices.invoice-list',[
            'invoices'=>Invoice::with('client')
                ->filter([
                    'search' =>$this->search,
                    'status' =>$this->status,
                    'client_id' =>$this->client_id,
                ])
                ->latest()
                ->paginate(15),
                'clients' => Client::orderBy('name')->get()
        ]);
    }
}