<?php

declare(strict_types=1);

namespace Tipoff\Reviews\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Tipoff\Reviews\Models\Insight;

class InsightFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Insight::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $location = randomOrCreate(app('location'));

        return [
            'location_id'                     => $location->id,
            'date'                            => $this->faker->date(),
            'searches_discovery'              => $this->faker->numberBetween(1, 16),
            'searches_direct'                 => $this->faker->numberBetween(1, 16),
            'searches_branded'                => $this->faker->numberBetween(1, 16),
            'views_maps'                      => $this->faker->numberBetween(1, 16),
            'views_search'                    => $this->faker->numberBetween(1, 16),
            'visits'                          => $this->faker->numberBetween(1, 16),
            'directions'                      => $this->faker->numberBetween(1, 16),
            'calls'                           => $this->faker->numberBetween(1, 16),
            'posts_views'                     => $this->faker->numberBetween(1, 1000),
            'photos_views_merchant'           => $this->faker->numberBetween(1, 16),
            'photos_views_customer'           => $this->faker->numberBetween(1, 16),
            'photos_count_merchant'           => $this->faker->numberBetween(1, 16),
            'photos_count_customer'           => $this->faker->numberBetween(1, 16),
        ];
    }
}
