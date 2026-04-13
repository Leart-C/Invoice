<?php

namespace App\Console\Commands;

use App\Models\Invoice;
use Illuminate\Console\Command;

class CheckOverdueInvoices extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'invoices:check-overdue';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Mark overdue invoices automatically';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $count = Invoice::whereIn('status',['sent','partial'])
            ->where('due_date','<',now())
            ->update(['status'=>'overdue']);

        $this->info("Marked ${$count} invoices as overdue");
    }
}
