<?php

namespace Database\Factories;

use App\Models\Client;
use App\Models\Invoice;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Invoice>
 */
class InvoiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $subtotal = fake()->randomFloat(2, 100, 5000);
        $tax      = round($subtotal * 0.18, 2);
        $total    = round($subtotal + $tax, 2);

        return [
            'client_id'      => Client::factory(),
            'invoice_number' => 'INV-' . date('Y') . '-' . str_pad(fake()->unique()->numberBetween(1, 999), 4, '0', STR_PAD_LEFT),
            'status'         => fake()->randomElement(['draft', 'sent', 'paid', 'partial', 'overdue']),
            'issue_date'     => fake()->dateTimeBetween('-6 months', 'now'),
            'due_date'       => fake()->dateTimeBetween('now', '+3 months'),
            'subtotal'       => $subtotal,
            'tax'            => $tax,
            'total'          => $total,
            'amount_paid'    => 0,
            'notes'          => fake()->optional()->sentence(),
        ];
    }
}
