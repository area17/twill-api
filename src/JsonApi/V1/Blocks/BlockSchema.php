<?php

namespace A17\Twill\API\JsonApi\V1\Blocks;

use A17\Twill\Models\Block;
use LaravelJsonApi\Eloquent\Schema;
use LaravelJsonApi\Eloquent\Fields\ID;
use LaravelJsonApi\Eloquent\Fields\Str;
use LaravelJsonApi\Eloquent\Fields\Number;
use LaravelJsonApi\Eloquent\Fields\ArrayHash;
use LaravelJsonApi\Eloquent\Filters\WhereIdIn;
use LaravelJsonApi\Eloquent\Contracts\Paginator;
use LaravelJsonApi\Eloquent\Fields\Relations\HasMany;
use LaravelJsonApi\Eloquent\Pagination\PagePagination;
use LaravelJsonApi\Eloquent\Fields\Relations\BelongsToMany;

class BlockSchema extends Schema
{

    /**
     * The model the schema corresponds to.
     *
     * @var string
     */
    public static string $model = Block::class;

    /**
    * The maximum depth of include paths.
    *
    * @var int
    */
    protected int $maxDepth = 4;

    /**
     * Get the resource fields.
     *
     * @return array
     */
    public function fields(): array
    {
        return [
            ID::make(),
            Str::make('blockType', 'type')->sortable()->readOnly(),
            ArrayHash::make('content')->sortKeys(),
            Str::make('editorName', 'editor_name'),
            Number::make('position')->sortable(),
            HasMany::make('blocks', 'children')->type('blocks'),
            BelongsToMany::make('mediables')->serializeUsing(
                static fn ($relation) => $relation->alwaysShowData()
            ),
            BelongsToMany::make('files')->serializeUsing(
                static fn ($relation) => $relation->alwaysShowData()
            ),
            BelongsToMany::make('related-items'),
        ];
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
