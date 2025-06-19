<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition()
    {
        return [
            'name' => $this->faker->word,
            'production_price' => $this->faker->numberBetween(10000, 50000),
            'selling_price' => $this->faker->numberBetween(60000, 100000),
        ];
    }
}
