<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@invoice.com',
            'password' => null,
            'role' => 'admin',
        ]);

        $clients = Client::factory()->count(10)->create();

        $clients->each(function ($client) {
            Invoice::factory()
                ->count(3)
                ->for($client)
                ->has(InvoiceItem::factory()->count(3), 'items')
                ->has(Payment::factory()->count(1), 'payments')
                ->create();
        });
    }
}
