<?php

namespace Database\Factories;

use App\Enums\ContactType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Contact>
 */
class ContactFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'contact_number' => $this->faker->phoneNumber(),
            'contact_type' => $this->faker->randomElement(ContactType::cases()),
        ];
    }
}
