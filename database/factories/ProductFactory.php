<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition()
    {
        return [
            'name' => $this->faker->word,
            'price' => $this->faker->randomFloat(2, 1, 100),
            'category' => $this->faker->word,
            'stock' => $this->faker->numberBetween(0, 100),
            'sold' => $this->faker->numberBetween(0, 100),
            'status' => $this->faker->randomElement(['Listed', 'Unlisted', 'Out of Stock']),
            'description' => $this->faker->sentence,
            'expiry_date' => $this->faker->date,
            'image' => 'https://via.placeholder.com/150',
        ];
    }
}
