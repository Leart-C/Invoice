<?php

namespace App\Observers;

use App\Models\Payment;
use PhpParser\Lexer\TokenEmulator\VoidCastEmulator;

class PaymentObserver
{
    /**
     * Handle the Payment "created" event.
     */
    public function created(Payment $payment): void
    {
        $this->recalculate($payment);
    }

    /**
     * Handle the Payment "deleted" event.
     */
    public function deleted(Payment $payment): void
    {
        $this->recalculate($payment);
    }

    public function recalculate(Payment $payment):void
    {
        $invoice = $payment->invoice;

        $totalPaid = $invoice->payments()->sum('amount');

        $invoice->amount_paid = $totalPaid;

        if($totalPaid <= 0){
            $invoice->status = 'sent';
        }elseif($totalPaid >= $invoice->total){
            $invoice->status = 'paid';
        }else{
            $invoice->status = 'partial';
        }

        $invoice->save();
    }
}
