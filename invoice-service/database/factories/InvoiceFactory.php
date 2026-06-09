<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class InvoiceFactory extends Factory
{
    public function definition(): array
    {
        return [
            'invoice_number' => 'INV-' . date('Y') . '-' . fake()->unique()->numerify('####'),
            'customer_id'    => fake()->numberBetween(1, 50),
            'amount'         => fake()->randomFloat(2, 150, 8500),
            'status'         => fake()->randomElement(['pending', 'paid', 'overdue']),
            'due_date'       => fake()->dateTimeBetween('-3 months', '+3 months')->format('Y-m-d'),
        ];
    }
}
