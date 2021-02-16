<?php

declare(strict_types=1);

namespace Tipoff\Reviews\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Place;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Panel;
use Tipoff\Support\Nova\BaseResource;

class Competitor extends BaseResource
{
    public static $model = \Tipoff\Reviews\Models\Competitor::class;

    public static $orderBy = ['id' => 'asc'];

    public static $title = 'name';

    public static $search = [
        'id',
    ];

    public static $group = 'Reporting';

    public static $perPageViaRelationship = 20;

    /** @psalm-suppress UndefinedClass */
    protected array $filterClassList = [

    ];

    public function fieldsForIndex(NovaRequest $request)
    {
        return array_filter([
            ID::make()->sortable(),
            nova('market') ? BelongsTo::make('Market', 'market', nova('market'))->sortable() : null,
            Text::make('Name')->sortable(),
        ]);
    }

    public function fields(Request $request)
    {
        return array_filter([

            Text::make('Name'),
            Text::make('Website', function () {
                return '<a href="'.$this->website.'">'.$this->website.'</a>';
            })->asHtml(),
            nova('market') ? BelongsTo::make('Market', 'market', nova('market'))->searchable() : null,
            nova('market') ? BelongsTo::make('Location', 'location', nova('market'))->nullable() : null,

            new Panel('Address Information', $this->addressFields()),

            new Panel('Data Fields', $this->dataFields()),

            new Panel('Hours of Operation', $this->hoursFields()),

            nova('snapshot') ? HasMany::make('Snapshots', 'snapshots', nova('snapshot')) : null,
        ]);
    }

    protected function addressFields()
    {
        return [
            Place::make('Address', 'address'),
            Text::make('Address Line 2', 'address2'),
            Text::make('City'),
            Text::make('State'),
            Text::make('ZIP'),
            Text::make('Phone'),
        ];
    }

    protected function dataFields(): array
    {
        return array_merge(
            parent::dataFields(),
            [
                Text::make('Map Link', function () {
                    return '<a href="'.$this->maps_url.'">'.$this->maps_url.'</a>';
                })->asHtml(),
                Text::make('Latitude'),
                Text::make('Longitude'),
                Text::make('Place ID', 'place_location'),
            ],
        );
    }

    protected function hoursFields()
    {
        return [
            Text::make('Monday Open'),
            Text::make('Monday Close'),
            Text::make('Tuesday Open'),
            Text::make('Tuesday Close'),
            Text::make('Wednesday Open'),
            Text::make('Wednesday Close'),
            Text::make('Thursday Open'),
            Text::make('Thursday Close'),
            Text::make('Friday Open'),
            Text::make('Friday Close'),
            Text::make('Saturday Open'),
            Text::make('Saturday Close'),
            Text::make('Sunday Open'),
            Text::make('Sunday Close'),
        ];
    }
}
