<?php

use App\Models\Client;
use App\Models\User;
use Laravel\Sanctum\Sanctum;

use function Pest\Laravel\getJson;

it('requires authentication to access the clients endpoint',function(){
    $response = getJson('/api/v1/clients');

    $response  
        ->assertUnauthorized()
        ->assertJson([
            'status' => 'error',
            'message' => 'Unauthenticated.',
            'data' => null,
        ]);
});

it('allows an authenticated user to access the clients endpoint',function(){
    $user = User::factory()->create([
        'role' => 'admin',
    ]);

    Client::factory()->count(3)->create();

    Sanctum::actingAs($user);

    $response = getJson('/api/v1/clients');

    $response   
        ->assertOk()
        ->assertJsonStructure([
            'status',
            'message',
            'data',
        ]);
});
