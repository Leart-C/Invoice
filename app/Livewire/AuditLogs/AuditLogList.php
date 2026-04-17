<?php

namespace App\Livewire\AuditLogs;

use App\Models\AuditLog;
use Livewire\Component;
use Livewire\WithPagination;

class AuditLogList extends Component
{
    use WithPagination;

    public string $filterModel = '';
    public string $filterAction = '';

    public function updatedFilterModel(): void {$this->resetPage();}
    public function updatedFilterAction(): void {$this->resetPage();}

    public function render()
    {
        $logs = AuditLog::with('user')
            ->when($this->filterModel, fn($q) => $q->byModel($this->filterModel))
            ->when($this->filterAction, fn($q) => $q->byAction($this->filterAction))
            ->latest()
            ->paginate(20);
        
        return view('livewire.audit-logs.audit-log-list',[
            'logs'=>$logs,
            'modelTypes'=>['Client','Invoice','Payment'],
            'actionTypes'=>['created','updated','deleted'],
        ]);
    }
}