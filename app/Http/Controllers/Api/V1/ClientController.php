<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\ClientDetailResource;
use App\Http\Resources\Api\V1\ClientResource;
use App\Models\Client;
use Illuminate\Support\Facades\DB;

class ClientController extends Controller
{
    public function index()
    {
        $clients = Client::query()
            ->select('clients.*')
            ->selectSub(function ($query) {
                $query->from('invoices')
                    ->selectRaw('COALESCE(SUM(total - amount_paid), 0)')
                    ->whereColumn('invoices.client_id', 'clients.id')
                    ->whereIn('status', ['sent', 'partial', 'overdue']);
            }, 'outstanding_balance_total')
            ->latest()
            ->paginate(15);

        return response()->json([
            'status' => 'success',
            'message' => 'Clients retrieved successfully.',
            'data' => ClientResource::collection($clients),
        ]);
    }

    public function show(Client $client)
    {
        $client->load([
            'invoices' => fn ($query) => $query->with('client')->latest(),
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Client retrieved successfully.',
            'data' => new ClientDetailResource($client),
        ]);
    }
}
