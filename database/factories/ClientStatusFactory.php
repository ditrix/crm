<?php

namespace Database\Factories;

use App\Models\ClientStatus;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<ClientStatus>
 */
class ClientStatusFactory extends Factory
{
    protected $model = ClientStatus::class;

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
