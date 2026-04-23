<?php

namespace Database\Factories;

use App\Models\Guest;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Guest>
 */
class GuestFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<\App\Models\Guest>
     */
    protected $model = Guest::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'phone' => $this->faker->phoneNumber(),
            'status' => $this->faker->randomElement(['pending', 'confirmed', 'declined', 'attended']),
            'participation_type' => $this->faker->randomElement(['attendee', 'speaker', 'sponsor', 'volunteer', 'vip']),
            'ticket_count' => $this->faker->numberBetween(1, 5),
            'company' => $this->faker->company(),
            'position' => $this->faker->jobTitle(),
            'dietary_requirements' => $this->faker->randomElement([null, 'Vegetarian', 'Vegan', 'Gluten-free']),
            'checked_in' => false,
            'registration_status' => 'confirmed',
        ];
    }
}
