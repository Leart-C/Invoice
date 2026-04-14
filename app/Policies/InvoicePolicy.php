<?php

namespace App\Policies;

use App\Models\Invoice;
use App\Models\User;

class InvoicePolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function downloadPdf(User $user,Invoice $invoice)
    {
        return in_array($user->role,['admin','accountant']);
    }
}
