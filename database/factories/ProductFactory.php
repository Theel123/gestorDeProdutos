<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        #$users = User::pluck('id')->toArray();

        return [
            'name' => fake()->name(),
           # 'user_id' => fake()->randomElement($users),
            'quantity' => fake()->randomElement(['10', '20']),
            'description' => 'Product Teste',
            'price' => fake()->randomElement([10.00, 20.00]),
            'status' => 1,
        ];
    }
}
