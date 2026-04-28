<?php

namespace App\Livewire\Clients;

use App\Models\Client;
use Livewire\Component;
use Livewire\WithPagination;

class ClientList extends Component
{
    use WithPagination;

    public string $search = '';
    public bool $showDeleteModal = false;
    public ?int $clientToDelete = null;

    public function updateSearch():void
    {
        $this->resetPage();
    }

    public function confirmDelete(int $clientId):void
    {
        $this->clientToDelete = $clientId;
        $this->showDeleteModal = true;
    }

    public function cancelDelete():void
    {
        $this->clientToDelete = null;
        $this->showDeleteModal = false;
    }

    public function delete():void
    {
        $client = Client::findOrFail($this->clientToDelete);

        if($client->hasActiveInvoices()){
            session($client->flash('error','Cannot delete a client with active invoices'));
            $this->cancelDelete();
            return;
        }

        $client->delete();
        session()->flash('success','Client delete successfully');
        $this->cancelDelete();
    }

    public function render()
    {
        $clients = Client::search($this->search)
            ->withCount('invoices')
            ->paginate(15);

        return view('livewire.clients.client-list',compact('clients'));
    }
}