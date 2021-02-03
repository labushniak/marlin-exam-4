<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\UsersInfo;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserInfoFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = UsersInfo::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => User::factory()->create(),
            'job_title' => $this->faker->jobTitle,
            'phone' => $this->faker->phoneNumber,
            'address' => $this->faker->streetAddress,
            'status' => $this->faker->randomElement(['dont_disturb', 'online', 'out']),

            
        ];
    }
}
