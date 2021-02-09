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
use Tipoff\Support\Nova\Resource;

class Competitor extends Resource
{
    public static $model = \Tipoff\Reviews\Models\Competitor::class;

    public static $orderBy = ['id' => 'asc'];

    public static $title = 'name';

    public static $search = [
        'id',
    ];

    public static $group = 'Reporting';

    public static $perPageViaRelationship = 20;

    public function fieldsForIndex(NovaRequest $request)
    {
        return [
            ID::make()->sortable(),
            BelongsTo::make('Market', 'market', app()->getAlias('nova.market'))->sortable(),
            Text::make('Name')->sortable(),
        ];
    }

    public function fields(Request $request)
    {
        return [

            Text::make('Name'),
            Text::make('Website', function () {
                return '<a href="'.$this->website.'">'.$this->website.'</a>';
            })->asHtml(),
            BelongsTo::make('Market', 'market', app()->getAlias('nova.market'))->searchable(),
            BelongsTo::make('Location', 'location', app()->getAlias('nova.location'))->nullable(),

            new Panel('Address Information', $this->addressFields()),

            new Panel('Data Fields', $this->dataFields()),

            new Panel('Hours of Operation', $this->hoursFields()),

            HasMany::make('Snapshots', 'snapshots', Snapshot::class),
        ];
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

    protected function dataFields()
    {
        return [
            Text::make('Map Link', function () {
                return '<a href="'.$this->maps_url.'">'.$this->maps_url.'</a>';
            })->asHtml(),
            ID::make(),
            Text::make('Latitude'),
            Text::make('Longitude'),
            Text::make('Place ID', 'place_location'),
        ];
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

    public function cards(Request $request)
    {
        return [];
    }

    public function filters(Request $request)
    {
        return [
            // TODO - figure out how to share this
            // new Filters\Market,
        ];
    }

    public function lenses(Request $request)
    {
        return [];
    }

    public function actions(Request $request)
    {
        return [];
    }
}
