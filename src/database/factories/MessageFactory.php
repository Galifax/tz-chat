<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class MessageFactory extends Factory
{
    public function definition(): array
    {
        return [
            'sender_id' => null,
            'receiver_id' => null,
            'message' => fake()->text(),
        ];
    }
}
