<?php

namespace Database\Factories;

use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;

class CustomerFactory extends Factory
{
    protected $model = Customer::class;

    public function definition()
    {
        return [
            'name'    => $this->faker->company,
            'address' => $this->faker->address,
            'phone'   => $this->faker->numerify('628##########'),
        ];
    }
}
