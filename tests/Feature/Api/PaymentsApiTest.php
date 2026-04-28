<?php

use App\Models\Client;
use App\Models\Invoice;
use App\Models\Payment;
use App\Models\User;
use Laravel\Sanctum\Sanctum;
use function Pest\Laravel\postJson;
use function Pest\Laravel\assertDatabaseHas;


it('prevents viewers from recording payments', function () {
    $user = User::factory()->create([
        'role' => 'viewer',
    ]);

    $client = Client::factory()->create();

    $invoice = Invoice::factory()->create([
        'client_id' => $client->id,
        'status' => 'sent',
        'amount_paid' => 0,
    ]);

    Sanctum::actingAs($user);

    $response = postJson("/api/v1/invoices/{$invoice->id}/payments", [
        'amount' => 50,
        'payment_date' => now()->format('Y-m-d'),
        'method' => 'cash',
        'notes' => 'Viewer trying to pay',
    ]);

    $response->assertForbidden();
});

it('returns validation errors for an invalid payment payload', function () {
    $user = User::factory()->create([
        'role' => 'admin',
    ]);

    $invoice = Invoice::factory()->create([
        'status' => 'sent',
        'amount_paid' => 0,
        'total' => 100,
    ]);

    Sanctum::actingAs($user);

    $response = postJson("/api/v1/invoices/{$invoice->id}/payments", [
        'amount' => 0,
        'payment_date' => '',
        'method' => 'invalid-method',
        'notes' => str_repeat('a', 501),
    ]);

    $response
        ->assertStatus(422)
        ->assertJson([
            'status' => 'error',
            'message' => 'Validation failed.',
        ])
        ->assertJsonStructure([
            'status',
            'message',
            'data' => [
                'errors' => [
                    'amount',
                    'payment_date',
                    'method',
                    'notes',
                ],
            ],
        ]);
});

it('records a payment for an authorized user', function () {
    $user = User::factory()->create([
        'role' => 'admin',
    ]);

    $invoice = Invoice::factory()->create([
        'status' => 'sent',
        'amount_paid' => 0,
        'total' => 200,
    ]);

    Sanctum::actingAs($user);

    $response = postJson("/api/v1/invoices/{$invoice->id}/payments", [
        'amount' => 50,
        'payment_date' => now()->format('Y-m-d'),
        'method' => 'cash',
        'notes' => 'Partial payment',
    ]);

    $response
        ->assertCreated()
        ->assertJson([
            'status' => 'success',
            'message' => 'Payment recorded successfully.',
        ])
        ->assertJsonStructure([
            'status',
            'message',
            'data' => [
                'id',
                'amount',
                'payment_date',
                'method',
                'notes',
                'created_at',
            ],
        ]);

    assertDatabaseHas('payments', [
        'invoice_id' => $invoice->id,
        'amount' => 50.00,
        'method' => 'cash',
        'notes' => 'Partial payment',
    ]);
});

it('updates the invoice amount paid and status after recording a payment', function () {
    $user = User::factory()->create([
        'role' => 'admin',
    ]);

    $invoice = Invoice::factory()->create([
        'status' => 'sent',
        'amount_paid' => 0,
        'total' => 200,
    ]);

    Sanctum::actingAs($user);

    postJson("/api/v1/invoices/{$invoice->id}/payments", [
        'amount' => 200,
        'payment_date' => now()->format('Y-m-d'),
        'method' => 'bank_transfer',
        'notes' => 'Paid in full',
    ])->assertCreated();

    $invoice->refresh();

    expect((float) $invoice->amount_paid)->toBe(200.0);
    expect($invoice->status)->toBe('paid');
});
