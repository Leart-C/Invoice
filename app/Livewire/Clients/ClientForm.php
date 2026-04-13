<?php

namespace App\Livewire\Clients;

use App\Models\Client;
use Livewire\Component;

class ClientForm extends Component
{
    public ?Client $client = null;

    public string $name         = '';
    public string $email        = '';
    public string $phone        = '';
    public string $address      = '';
    public string $company_name = '';

    
    public function mount(?Client $client = null): void
    {
        if ($client && $client->exists) {
            $this->client = $client;
            $this->name = $client->name ?? '';
            $this->email = $client->email ?? '';
            $this->phone = $client->phone ?? '';
            $this->address = $client->address ?? '';
            $this->company_name = $client->company_name ?? '';
        }
    }

    
    protected function rules(): array
    {
        $emailRule = 'required|email|unique:clients,email';

        
        if ($this->client) {
            $emailRule .= ',' . $this->client->id;
        }

        return [
            'name' => 'required|string|max:255',
            'email' => $emailRule,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'company_name' => 'nullable|string|max:255',
        ];
    }

    public function save(): void
    {
        $validated = $this->validate();
        
        if ($this->client) {
            $this->client->update($validated);
            session()->flash('success', 'Client updated successfully.');
        } else {
            Client::create($validated);
            session()->flash('success', 'Client created successfully.');
        }

        $this->redirect(route('clients.index'));
    }

    public function render()
    {
        return view('livewire.clients.client-form');
    }
}