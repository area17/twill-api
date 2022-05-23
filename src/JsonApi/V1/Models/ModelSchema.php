<?php

namespace A17\Twill\API\JsonApi\V1\Models;

use LaravelJsonApi\Eloquent\Schema;
use LaravelJsonApi\Eloquent\Fields\ID;
use LaravelJsonApi\Eloquent\Fields\Str;
use LaravelJsonApi\Eloquent\Fields\Number;
use LaravelJsonApi\Eloquent\Filters\Where;
use A17\Twill\API\JsonApi\Filters\WhereSlug;
use LaravelJsonApi\Eloquent\Fields\DateTime;
use LaravelJsonApi\Eloquent\Filters\WhereIdIn;
use LaravelJsonApi\Eloquent\Contracts\Paginator;
use LaravelJsonApi\Eloquent\Pagination\PagePagination;
use LaravelJsonApi\Eloquent\Fields\Relations\BelongsToMany;

abstract class ModelSchema extends Schema
{
    public const STATUS_PUBLISHED = 'published';

    public const STATUS_DRAFT = 'draft';

    protected bool $statusAttribute = true;

    /**
    * The maximum depth of include paths.
    *
    * @var int
    */
    protected int $maxDepth = 3;

    /**
     * Get the resource fields.
     *
     * @return array
     */
    public function fields(): array
    {
        $fields = [
            ID::make(),
        ];

        if ($this->statusAttribute) {
            $fields[] = Str::make('status', 'published')->serializeUsing(
                static fn ($value) => $value ? self::STATUS_PUBLISHED : self::STATUS_DRAFT
            );
        }

        if (classHasTrait($this->model(), 'A17\Twill\Models\Behaviors\HasPosition')) {
            $fields[] = Number::make('position')->sortable();
        }

        if (classHasTrait($this->model(), 'A17\Twill\API\Models\Traits\HasChildBlocks')) {
            $fields[] = BelongsToMany::make('blocks', 'parentBlocks')->type('blocks');
        } elseif (classHasTrait($this->model(), 'A17\Twill\Models\Behaviors\HasBlocks')) {
            $fields[] = BelongsToMany::make('blocks');
        }

        if (classHasTrait($this->model(), 'A17\Twill\Models\Behaviors\HasMedias')) {
            $fields[] = BelongsToMany::make('media', 'mediables')->type('media');
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
        $filters = [
            WhereIdIn::make($this),
        ];

        if ($this->statusAttribute) {
            $filters[] = Where::make('status', 'published')->deserializeUsing(
                fn ($value) => $value === self::STATUS_PUBLISHED
            );
        }

        if (classHasTrait($this->model(), 'A17\Twill\Models\Behaviors\HasSlug')) {
            $filters[] = WhereSlug::make('slug')->singular();
        }

        return $filters;
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
