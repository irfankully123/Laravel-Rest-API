<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;
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
        return [
            'name' => fake()->name(),
            'quantity' => fake()->randomDigitNotNull(),
            'brand' => fake()->domainWord(),
            'model' => fake()->word(),
            'category'=>fake()->company(),
            'stock'=>'instock',
            'price'=>fake()->numberBetween($min = 1000, $max = 9000),
            'created_at'=>Carbon::now(),
            'updated_at'=>Carbon::now()  
        ];
    }
}
