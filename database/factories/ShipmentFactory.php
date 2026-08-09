<?php

namespace Database\Factories;

use App\Models\Shipment;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Shipment>
 */
class ShipmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(4),
            'from_city' => $this->faker->city(),
            'from_country' => $this->faker->country(),
            'to_city' => $this->faker->city(),
            'to_country' => $this->faker->country(),
            'price' => $this->faker->numberBetween(50, 5000),
            'status' => $this->faker->randomElement([
                Shipment::STATUS_UNASSIGNED,
                Shipment::STATUS_COMPLETED,
                Shipment::STATUS_PROBLEM,
                Shipment::STATUS_IN_PROGRESS,
            ]),
            'user_id' => User::factory(),
            'details' => $this->faker->paragraph(),
        ];
    }
}
