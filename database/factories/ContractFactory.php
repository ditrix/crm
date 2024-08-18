<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Contract>
 */
class ContractFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => fake()->numberBetween(1,5),
            'contract_type_id'      => fake()->numberBetween(1,3),
            'contract_status_id'    => fake()->numberBetween(1,5),
            'code'                  => fake()->buildingNumber(),
            'title'                 => fake()->jobTitle(),
            'comment'               => 'comment for contract ...',
            'summ'                  => fake()->buildingNumber(),
            'is_active'             => fake()->boolean(),
            'active_from'           => fake()->dateTimeThisDecade(),
            'active_to'             => fake()->dateTimeThisDecade(),
            'updated_at'            =>  now(),
            'created_at'            =>  now()
        ];
    }
}
