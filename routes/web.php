<?php

use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\InvoiceController;
use App\Models\Client;
use App\Models\Invoice;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

//public routes
Route::get('/login',function(){
    return view('auth.login');
})->name('login');

Route::get('/auth/google/redirect',[GoogleController::class,'redirect'])->name('google.redirect');

Route::get('/auth/google/callback',[GoogleController::class, 'callback'])->name('google.callback');

Route::post('/logout',[GoogleController::class, 'logout'])->name('logout');

//protected routes
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('pages.dashboard');
    })->name('dashboard');

    // Clients
    Route::get('/clients', fn() => view('pages.clients.index'))->name('clients.index');
    Route::get('/clients/create', fn() => view('pages.clients.create'))->name('clients.create');
    Route::get('/clients/{client}/edit', fn(Client $client) => view('pages.clients.edit', compact('client')))->name('client.edit');
    Route::get('/clients/{client}', fn(Client $client) => view('pages.clients.profile', compact('client')))->name('clients.show');

    // Invoices — specific routes FIRST, wildcard {invoice} LAST
    Route::get('/invoices', fn() => view('pages.invoices.index'))->name('invoices.index');
    Route::get('/invoices/create', fn() => view('pages.invoices.create'))->name('invoices.create');
    Route::get('/invoices/{invoice}/edit', fn(Invoice $invoice) => view('pages.invoices.edit', compact('invoice')))->name('invoices.edit');
    Route::get('/invoices/{invoice}/pay', fn(Invoice $invoice) => view('pages.payments.create', compact('invoice')))->name('payments.create');
    Route::get('/invoices/{invoice}', fn(Invoice $invoice) => view('pages.invoices.detail', compact('invoice')))->name('invoices.show');
    Route::get('invoices/{id}/pdf',[InvoiceController::class,'download'])->name('invoices.pdf');

    //Audit
    Route::get('/audit-logs', function(){
        if(Auth::user()->role !== 'admin'){
            abort(403,'Access denied.');
        }
        return view('pages.audit-logs.index');
    })->name('audit-logs.index');

    //Admin
    Route::get('/admin/settings/tokens', function (){
        if(Auth::user()->role !== 'admin'){
            abort(403,'Access denied');
        }
        return view('pages.settings.tokens');
    })->name('admin.settings.tokens');
});
