<?php

namespace Database\Factories;

use App\Models\Invoice;
use App\Models\Payment;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Payment>
 */
class PaymentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'invoice_id'   => Invoice::factory(),
            'amount'       => fake()->randomFloat(2, 50, 1000),
            'payment_date' => fake()->dateTimeBetween('-3 months', 'now'),
            'method'       => fake()->randomElement(['cash', 'bank_transfer', 'card', 'other']),
            'notes'        => fake()->optional()->sentence(),
        ];
    }
}
