<?php

namespace Database\Factories;

use App\Models\Reminder;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Reminder>
 */
class ReminderFactory extends Factory
{
    protected $model = Reminder::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'message' => fake()->sentence(),
            'remind_at' => now()->subHour(),
            'notified_at' => null,
        ];
    }

    public function dismissed(): static
    {
        return $this->state(fn (array $attributes) => [
            'notified_at' => now(),
        ]);
    }
}
