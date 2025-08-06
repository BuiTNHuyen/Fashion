<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    protected $model = Order::class;

    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'name' => $this->faker->name(),
            'email' => $this->faker->email(),
            'phone' => $this->faker->phoneNumber(),
            'address' => $this->faker->address(),
            'note' => $this->faker->optional(0.7)->sentence(),
            'total_price' => $this->faker->randomFloat(2, 100, 1000),
            'payment' => $this->faker->randomElement(['COD', 'BANK']),
            'status' => $this->faker->numberBetween(0, 4),
            'created_at' => $this->faker->dateTimeBetween('-3 months', 'now'),  
            'updated_at' => function (array $attributes) {
                return $attributes['created_at'];
            },
        ];
    }
} 