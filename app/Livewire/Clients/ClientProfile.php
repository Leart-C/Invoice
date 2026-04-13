<?php

namespace App\Livewire\Clients;

use App\Models\Client;
use Livewire\Component;

class ClientProfile extends Component
{
    public Client $client;

    public function mount(Client $client): void
    {
        $this->client = $client;
    }

    public function render()
    {
        $invoices = $this->client
            ->invoices()
            ->with('payments')
            ->latest()
            ->get();

        return view('livewire.clients.client-profile', [
            'invoices' => $invoices,
            'outstandingBalance' => $this->client->outstanding_balance,
        ]);
    }
}