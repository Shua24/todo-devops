<?php

namespace Database\Factories;

use App\Models\todo;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class TodoFactory extends Factory
{
    protected $model = todo::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(), // associate with a new user by default
            'name' => $this->faker->sentence(3),
            'deadline' => $this->faker->dateTimeBetween('tomorrow', '+1 month'),
            'is_completed' => false,
        ];
    }
}

