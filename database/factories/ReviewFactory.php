<?php

declare(strict_types=1);

namespace Tipoff\Reviews\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Tipoff\Reviews\Models\Review;

class ReviewFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Review::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'google_ref'        => $this->faker->md5,
            'rating'            => $this->faker->numberBetween(1, 10),
            'comment'           => $this->faker->sentences(3, true),
            'reviewer'          => $this->faker->name,
            'reviewer_photo'    => $this->faker->word,

            'reviewed_at'       => $this->faker->dateTimeBetween($startDate = '-7 days', $endDate = 'now', $timezone = null),
            'reply'             => $this->faker->sentences(3, true),
            'replied_at'        => $this->faker->dateTimeBetween($startDate = '-7 days', $endDate = 'now', $timezone = null),
            'location_id'       => randomOrCreate(config('tipoff.model_class.location')),
        ];
    }
}
