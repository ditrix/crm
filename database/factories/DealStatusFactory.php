<?php

namespace Database\Factories;

use App\Models\DealStatus;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<DealStatus>
 */
class DealStatusFactory extends Factory
{
    protected $model = DealStatus::class;

    public function definition(): array
    {
        $name = fake()->unique()->words(2, true);

        return [
            'name' => $name,
            'slug' => Str::slug($name),
            'sort_order' => fake()->numberBetween(0, 100),
        ];
    }
}
