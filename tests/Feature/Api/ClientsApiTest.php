<?php

use App\Models\Client;
use App\Models\Invoice;
use App\Models\User;
use Laravel\Sanctum\Sanctum;
use function Pest\Laravel\getJson;

it('returns a paginated list of clients', function () {
    $user = User::factory()->create([
        'role' => 'admin',
    ]);

    Client::factory()->count(3)->create();

    Sanctum::actingAs($user);

    $response = getJson('/api/v1/clients');

    $response
        ->assertOk()
        ->assertJson([
            'status' => 'success',
            'message' => 'Clients retrieved successfully.',
        ])
        ->assertJsonStructure([
            'status',
            'message',
            'data' => [
                '*' => [
                    'id',
                    'name',
                    'email',
                    'phone',
                    'company_name',
                    'outstanding_balance',
                    'created_at',
                ],
            ],
        ]);
});

it('returns a single client with invoices', function () {
    $user = User::factory()->create([
        'role' => 'admin',
    ]);

    $client = Client::factory()->create();

    Invoice::factory()->count(2)->create([
        'client_id' => $client->id,
    ]);

    Sanctum::actingAs($user);

    $response = getJson("/api/v1/clients/{$client->id}");

    $response
        ->assertOk()
        ->assertJson([
            'status' => 'success',
            'message' => 'Client retrieved successfully.',
        ])
        ->assertJsonStructure([
            'status',
            'message',
            'data' => [
                'id',
                'name',
                'email',
                'phone',
                'address',
                'company_name',
                'outstanding_balance',
                'invoices',
                'created_at',
            ],
        ]);

    expect($response->json('data.invoices'))->toHaveCount(2);
});
