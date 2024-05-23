<?php

namespace Database\Factories;

use App\Models\Driver;
use App\Models\CarCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Car>
 */
class CarFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'model' => $this->faker->text(15),
            'category_id' => CarCategory::get()->random()->id,
            'driver_id' => Driver::get()->random()->id,
        ];
    }
}
