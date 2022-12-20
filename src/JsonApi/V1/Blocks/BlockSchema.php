<?php

namespace A17\Twill\API\JsonApi\V1\Blocks;

use A17\Twill\API\JsonApi\V1\Models\ModelSchema;
use A17\Twill\Models\Block;
use LaravelJsonApi\Eloquent\Fields\ID;
use LaravelJsonApi\Eloquent\Fields\Str;
use LaravelJsonApi\Eloquent\Fields\Number;
use LaravelJsonApi\Eloquent\Filters\Where;
use LaravelJsonApi\Eloquent\Fields\ArrayHash;
use LaravelJsonApi\Eloquent\Filters\WhereIdIn;
use LaravelJsonApi\Eloquent\Contracts\Paginator;
use LaravelJsonApi\Eloquent\Pagination\PagePagination;

class BlockSchema extends ModelSchema
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
        $fields = parent::fields();

        return array_merge($fields, [
            ID::make(),
            Str::make('blockType', 'type')->sortable()->readOnly(),
            ArrayHash::make('content')->sortKeys(),
            Str::make('editorName', 'editor_name'),
            Str::make('childKey', 'child_key'),
            Number::make('position')->sortable(),
        ]);
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
            Where::make('blockType', 'type'),
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
