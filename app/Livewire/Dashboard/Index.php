<?php

namespace App\Livewire\Dashboard;

use App\Services\DashboardMetricsService;
use Livewire\Component;

class Index extends Component
{
    public array $metrics = [];
    public $recentInvoices = [];
    public $dueSoonInvoices = [];
    public $topClients = [];
    public $revenueComparison = [];



    public function mount()
    {
        $this->loadMetrics();
    }

    public function loadMetrics()
    {
        $service = app(\App\Services\DashboardMetricsService::class);

        $this->metrics = [
            'totalRevenue' => $service->totalRevenue(),
            'outstanding' => $service->outstandingBalance(),
            'overdue' => $service->overdueInvoicesCount(),
            'clients' => $service->totalClients(),
        ];

        $this->recentInvoices = $service->recentInvoices();
        $this->dueSoonInvoices = $service->dueSoonInvoices();
        $this->topClients = $service->topClientsByBalance();
        $this->revenueComparison = $service->revenueComparison();
    }


    public function render()
    {
        return view('livewire.dashboard.index');
    }

    
}