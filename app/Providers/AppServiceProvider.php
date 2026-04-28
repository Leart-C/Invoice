<?php

namespace App\Providers;

use App\Models\Invoice;
use App\Models\Payment;
use App\Observers\PaymentObserver;
use App\Policies\InvoicePolicy;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    protected $policies = [
        Invoice::class => InvoicePolicy::class,
    ];
    
    public function boot(): void
    {
        Payment::observe(PaymentObserver::class);
    }
}
