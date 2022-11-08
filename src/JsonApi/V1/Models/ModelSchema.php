<?php

namespace A17\Twill\API\JsonApi\V1\Models;

use A17\Twill\API\Constants\Status;
use LaravelJsonApi\Eloquent\Fields\Boolean;
use LaravelJsonApi\Eloquent\Filters\Scope;
use LaravelJsonApi\Eloquent\Schema;
use LaravelJsonApi\Eloquent\Fields\ID;
use LaravelJsonApi\Eloquent\Fields\Str;
use LaravelJsonApi\Eloquent\Fields\Number;
use A17\Twill\API\JsonApi\Filters\WhereSlug;
use LaravelJsonApi\Eloquent\Filters\WhereIdIn;
use LaravelJsonApi\Eloquent\Contracts\Paginator;
use LaravelJsonApi\Eloquent\Pagination\PagePagination;
use LaravelJsonApi\Eloquent\Fields\Relations\BelongsToMany;

abstract class ModelSchema extends Schema
{
    protected bool $publishedAttribute = true;

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

        if ($this->publishedAttribute) {
            $fields[] = Boolean::make('published');
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
            $fields[] = BelongsToMany::make('files', 'fileables')->type('files');
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

        if ($this->publishedAttribute) {
            $filters[] = Scope::make('published')->asBoolean();
        }

        if (classHasTrait($this->model(), 'A17\Twill\Models\Behaviors\HasSlug')) {
            $filters[] = WhereSlug::make('slug')->singular();
            $filters[] = WhereSlug::make('slugs', 'slug');
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
