<?php

namespace Database\Factories\Dealskoo\User\Models;

use Dealskoo\Country\Models\Country;
use Dealskoo\User\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'slug' => $this->faker->unique()->slug(),
            'avatar' => $this->faker->imageUrl(60, 60),
            'cover' => $this->faker->imageUrl(60, 60),
            'name' => $this->faker->name(),
            'bio' => $this->faker->text(30),
            'email' => $this->faker->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
            'country_id' => Country::factory(),
            'company_name' => $this->faker->company(),
            'website' => $this->faker->domainName(),
            'status' => true,
        ];
    }

    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }

    public function inactive()
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => false,
            ];
        });
    }
}
