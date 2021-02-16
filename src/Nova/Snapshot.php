<?php

declare(strict_types=1);

namespace Tipoff\Reviews\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Tipoff\Support\Nova\BaseResource;

class Snapshot extends BaseResource
{
    public static $model = \Tipoff\Reviews\Models\Snapshot::class;

    public static function label()
    {
        return 'Review Snapshots';
    }

    public static function singularLabel()
    {
        return 'Snapshot';
    }

    public static $title = 'id';

    public static $search = [
        'id',
    ];

    public static $group = 'Reporting';

    public static $perPageViaRelationship = 10;

    /** @psalm-suppress UndefinedClass */
    protected array $filterClassList = [

    ];

    public function fieldsForIndex(NovaRequest $request)
    {
        return array_filter([
            ID::make()->sortable(),
            nova('competitor') ? BelongsTo::make('Competitor', 'competitor', nova('competitor'))->sortable() : null,
            Date::make('Date')->sortable(),
            Number::make('Reviews')->sortable(),
            Text::make('Rating')->sortable(),
        ]);
    }

    public function fields(Request $request)
    {
        return array_filter([
            Date::make('Date'),
            Number::make('Reviews'),
            Text::make('Rating'),
            nova('competitor') ? BelongsTo::make('Competitor', 'competitor', nova('competitor')) : null,
            ID::make(),
        ]);
    }
}
