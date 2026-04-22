<?php

use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Payment;
use App\Models\User;
use Laravel\Sanctum\Sanctum;
use function Pest\Laravel\getJson;

it('returns a filtered paginated list of invoices', function () {
    $user = User::factory()->create([
        'role' => 'admin',
    ]);

    Invoice::factory()->create([
        'status' => 'sent',
        'invoice_number' => 'INV-TEST-1001',
    ]);

    Invoice::factory()->create([
        'status' => 'paid',
        'invoice_number' => 'INV-TEST-1002',
    ]);

    Sanctum::actingAs($user);

    $response = getJson('/api/v1/invoices?status=sent');

    $response
        ->assertOk()
        ->assertJson([
            'status' => 'success',
            'message' => 'Invoices retrieved successfully.',
        ])
        ->assertJsonStructure([
            'status',
            'message',
            'data' => [
                '*' => [
                    'id',
                    'invoice_number',
                    'status',
                    'issue_date',
                    'due_date',
                    'subtotal',
                    'tax',
                    'total',
                    'amount_paid',
                    'remaining_balance',
                    'client',
                    'created_at',
                ],
            ],
        ]);

    expect($response->json('data'))->toHaveCount(1);
    expect($response->json('data.0.status'))->toBe('sent');
});

it('returns a single invoice with items and payments', function () {
    $user = User::factory()->create([
        'role' => 'admin',
    ]);

    $invoice = Invoice::factory()->create([
        'status' => 'partial',
        'amount_paid' => 50,
    ]);

    InvoiceItem::factory()->count(2)->create([
        'invoice_id' => $invoice->id,
    ]);

    Payment::factory()->count(1)->create([
        'invoice_id' => $invoice->id,
        'amount' => 50,
    ]);

    Sanctum::actingAs($user);

    $response = getJson("/api/v1/invoices/{$invoice->id}");

    $response
        ->assertOk()
        ->assertJson([
            'status' => 'success',
            'message' => 'Invoice retrieved successfully.',
        ])
        ->assertJsonStructure([
            'status',
            'message',
            'data' => [
                'id',
                'invoice_number',
                'status',
                'issue_date',
                'due_date',
                'subtotal',
                'tax',
                'total',
                'amount_paid',
                'remaining_balance',
                'notes',
                'client',
                'items',
                'payments',
                'created_at',
            ],
        ]);

    expect($response->json('data.items'))->toHaveCount(2);
    expect($response->json('data.payments'))->toHaveCount(1);
    expect($response->json('data.status'))->toBe('partial');


});
