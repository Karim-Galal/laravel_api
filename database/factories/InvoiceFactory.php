<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

use App\Models\User;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Invoice>
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
        $status = $this->faker->randomElement(['billed', 'paid', 'void']);
        $billedAt = $this->faker->dateTimeBetween('-1 year', 'now');
        $paidAt = $status === 'paid' ? $this->faker->dateTimeBetween($billedAt, 'now') : null;

        return [
            'customer_id' => function () {
                return User::where('role', 'customer')
                          ->inRandomOrder()
                          ->first()
                          ->id;
            },
            'amount' => $this->faker->numberBetween(100, 10000),
            'status' => $status,
            'billed_at' => $billedAt,
            'paid_at' => $paidAt,
        ];
    }
}
