<?php

declare(strict_types=1);

namespace Tipoff\Reviews\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Tipoff\Reviews\Models\Competitor;

class CompetitorFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Competitor::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $city = $this->faker->city;

        return [
            'market_id'             => randomOrCreate(app('market')),
            'domestic_address_id'   => randomOrCreate(app('domestic_address')),
            'place_location'        => $this->faker->unique()->md5,
            'name'                  => $this->faker->word,
            'address'               => $this->faker->address,
            'address2'              => $this->faker->address,
            'city'                  => $this->faker->city,
            'state'                 => $this->faker->stateAbbr,
            'zip'                   => $this->faker->postcode,
            'maps_url'              => $this->faker->unique()->url,
            'website'               => $this->faker->domainName,
            'location_id'           => null,
        ];
    }
}
