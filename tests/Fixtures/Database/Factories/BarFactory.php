<?php

namespace LaraChimp\MangoRepo\Tests\Fixtures\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use LaraChimp\MangoRepo\Tests\Fixtures\Models\Bar;

class BarFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Bar::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'is_active' => true,
        ];
    }
}
