<?php

namespace Database\Factories;

use App\Models\Brand;
use Illuminate\Database\Eloquent\Factories\Factory;

class BrandFactory extends Factory
{
    protected $model = Brand::class;

    public function definition()
    {
        return [
            // Define your Brand model's attributes here for generating sample data
            'brand_name' => $this->faker->word,
            'brand_code' => $this->faker->word,
            // Other attributes...
        ];
    }
}
