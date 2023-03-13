<?php

namespace Database\Factories;

use App\Models\Maintenance\MaintenanceJob;
use Illuminate\Database\Eloquent\Factories\Factory;

class MaintenanceJobFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = MaintenanceJob::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'person_name' => $this->faker->name(),
            'person_email' => $this->faker->unique()->safeEmail(),
        ];
    }
}
