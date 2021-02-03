<?php

namespace Database\Factories;

use App\Models\Model;
use App\Models\UsersLinks;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserLinksFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = UsersLinks::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'vk' => $this->faker->word,
            'telegram' => $this->faker->word,
            'instagram' => $this->faker->word,
        ];
    }
}
