<?php

namespace A17\Twill\API\JsonApi\V1\RelatedItems;

use A17\Twill\Models\RelatedItem;
use LaravelJsonApi\Eloquent\Schema;
use LaravelJsonApi\Eloquent\Fields\ID;
use LaravelJsonApi\Eloquent\Fields\Str;
use LaravelJsonApi\Eloquent\Fields\Number;
use LaravelJsonApi\Eloquent\Filters\WhereIdIn;
use LaravelJsonApi\Eloquent\Contracts\Paginator;
use LaravelJsonApi\Eloquent\Fields\Relations\HasOne;
use LaravelJsonApi\Eloquent\Fields\Relations\MorphTo;
use LaravelJsonApi\Eloquent\Pagination\PagePagination;

class RelatedItemSchema extends Schema
{

    /**
     * The model the schema corresponds to.
     *
     * @var string
     */
    public static string $model = RelatedItem::class;

    /**
    * The maximum depth of include paths.
    *
    * @var int
    */
    protected int $maxDepth = 2;

    protected $defaultSort = 'position';

    /**
     * Get the resource fields.
     *
     * @return array
     */
    public function fields(): array
    {
        $fields = [
            ID::make('id'),
            Str::make('browserName', 'browser_name'),
            Number::make('position')->sortable(),
        ];

        $relatedTypes = config('twill-api.related_types');

        if (count($relatedTypes) === 1) {
            $fields[] = HasOne::make('related')->type(...$relatedTypes);
        } elseif (count($relatedTypes) > 1) {
            $fields[] = MorphTo::make('related')->types(...$relatedTypes);
        }

        return $fields;
    }

    /**
     * Get the resource filters.
     *
     * @return array
     */
    public function filters(): array
    {
        return [
            WhereIdIn::make($this),
        ];
    }

    /**
     * Get the resource paginator.
     *
     * @return Paginator|null
     */
    public function pagination(): ?Paginator
    {
        return PagePagination::make();
    }
}
