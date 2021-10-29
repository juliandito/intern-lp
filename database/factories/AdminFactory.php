<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class AdminFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => 'Admin Blog',
            'email' => 'webadmin@gmail.com',
            'email_verified_at' => now(),
            'password' => bcrypt('webadmin12345678'),
        ];
    }
}
