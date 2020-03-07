<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\Trix;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\BelongsToMany;
use Laravel\Nova\Fields\Heading;
use Laravel\Nova\Http\Requests\NovaRequest;

class Project extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = 'App\Project';

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'name';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id', 'name',
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function fields(Request $request)
    {
        return [
            ID::make()
                ->hideFromIndex(),
            Text::make('Name', 'name')
                ->sortable(),
            Trix::make('Description', 'description'),
            BelongsToMany::make('Skills'),
            BelongsTo::make('Status'),
            Number::make('Bid Count', 'bid_count')
                ->sortable(),
            Boolean::make('Remote Job', 'is_remote_job')
                ->hideFromIndex(),
            Boolean::make('Premium', 'is_premium')
                ->hideFromIndex(),
            Boolean::make('Only for Plus', 'is_only_for_plus')
                ->hideFromIndex(),
            Select::make('Safe Type', 'safe_type')
                ->options([
                    'employer' => 'Employer',
                    'split' => 'Split',
                    'developer' => 'Developer',
                ])->displayUsingLabels()
                ->hideFromIndex(),
            Boolean::make('Personal', 'is_personal')
                ->hideFromIndex(),
            BelongsTo::make('Employer')
                ->sortable(),
            BelongsToMany::make('Tags'),
            DateTime::make('Published', 'published_at')->hideFromIndex(),
            DateTime::make('Expired', 'expired_at')->hideFromIndex(),

            Text::make('Location')
                ->withMeta([
                    'extraAttributes' => [
                        'style' => 'display: none',
                    ],
                ]),

            Text::make('Country', 'location[country]')
                ->withMeta([
                    'asHtml' => true,
                    'value' => isset($this->location['country']) ? $this->location['country'] : ''
                ])
                ->onlyOnForms(),
            Text::make('City', 'location[city]')
                ->withMeta([
                    'value' => isset($this->location['city']) ? $this->location['city'] : ''
                ])
                ->onlyOnForms(),
        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function cards(Request $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function filters(Request $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function lenses(Request $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function actions(Request $request)
    {
        return [];
    }
}
