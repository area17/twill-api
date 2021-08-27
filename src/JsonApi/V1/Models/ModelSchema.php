<?php

namespace A17\Twill\API\JsonApi\V1\Models;

use LaravelJsonApi\Eloquent\Contracts\Paginator;
use LaravelJsonApi\Eloquent\Fields\DateTime;
use LaravelJsonApi\Eloquent\Fields\ID;
use LaravelJsonApi\Eloquent\Fields\Number;
use LaravelJsonApi\Eloquent\Fields\Relations\BelongsToMany;
use LaravelJsonApi\Eloquent\Fields\Str;
use LaravelJsonApi\Eloquent\Filters\Where;
use LaravelJsonApi\Eloquent\Filters\WhereIdIn;
use LaravelJsonApi\Eloquent\Pagination\PagePagination;
use LaravelJsonApi\Eloquent\Schema;

abstract class ModelSchema extends Schema
{
    public const STATUS_PUBLISHED = 'published';
    public const STATUS_DRAFT = 'draft';

    /**
     * Get the resource fields.
     *
     * @return array
     */
    public function fields(): array
    {
        $fields = [
            ID::make(),
            DateTime::make('createdAt')->sortable()->readOnly(),
            DateTime::make('updatedAt')->sortable()->readOnly(),
            Str::make('status', 'published')->serializeUsing(
                static fn ($value) => $value ? self::STATUS_PUBLISHED : self::STATUS_DRAFT
            ),
        ];

        if (classHasTrait($this->model(), 'A17\Twill\Models\Behaviors\HasPosition')) {
            $fields[] = Number::make('position')->sortable();
        }

        if (classHasTrait($this->model(), 'A17\Twill\Models\Behaviors\HasBlocks')) {
            $fields[] = BelongsToMany::make('blocks');
        }

        if (classHasTrait($this->model(), 'A17\Twill\Models\Behaviors\HasFiles')) {
            $fields[] = BelongsToMany::make('files');
        }

        if (classHasTrait($this->model(), 'A17\Twill\Models\Behaviors\HasSlug')) {
            $fields[] = Str::make('slug');
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
            Where::make('status', 'published')->deserializeUsing(
                fn ($value) => $value === self::STATUS_PUBLISHED
            ),
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
