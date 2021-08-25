<?php

namespace A17\Twill\API\JsonApi\V1\Blocks;

use A17\Twill\Models\Block;
use LaravelJsonApi\Eloquent\Schema;
use LaravelJsonApi\Eloquent\Fields\ID;
use LaravelJsonApi\Eloquent\Fields\Str;
use LaravelJsonApi\Eloquent\Fields\DateTime;
use LaravelJsonApi\Eloquent\Fields\ArrayHash;
use LaravelJsonApi\Eloquent\Filters\WhereIdIn;
use LaravelJsonApi\Eloquent\Contracts\Paginator;
use LaravelJsonApi\Eloquent\Fields\Relations\MorphTo;
use LaravelJsonApi\Eloquent\Pagination\PagePagination;

class BlockSchema extends Schema
{

    /**
     * The model the schema corresponds to.
     *
     * @var string
     */
    public static string $model = Block::class;

    /**
     * Blockable models
     */
    public array $blockable = [];

    /**
     * Get the resource fields.
     *
     * @return array
     */
    public function fields(): array
    {
        $blockableField = $this->blockableField();

        return [
            ID::make(),
            DateTime::make('createdAt')->sortable()->readOnly(),
            DateTime::make('updatedAt')->sortable()->readOnly(),
            Str::make('type')->sortable()->readOnly(),
            ArrayHash::make('content')->sortKeys(),
            ...$blockableField,
        ];
    }

    protected function blockableField(): array
    {
        $count = count($this->blockable);

        if ($count === 0) {
            return [];
        }

        return [
            $count === 1
                ? MorphTo::make('blockable')->type(...$this->blockable)
                : MorphTo::make('blockable')->types(...$this->blockable)
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
