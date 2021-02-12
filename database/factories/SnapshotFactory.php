<?php

declare(strict_types=1);

namespace Tipoff\Reviews\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Tipoff\Reviews\Models\Competitor;
use Tipoff\Reviews\Models\Snapshot;

class SnapshotFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Snapshot::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'competitor_id'     => randomOrCreate(app('competitor')),
            'date'              => $this->faker->date,
            'reviews'           => $this->faker->numberBetween(1, 8),
        ];
    }
}
