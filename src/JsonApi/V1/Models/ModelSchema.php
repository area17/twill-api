<?php

namespace A17\Twill\API\JsonApi\V1\Models;

use A17\Twill\API\JsonApi\V1\Blocks\BlockSchema;
use A17\Twill\Models\Block;
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

        if (classHasTrait($this->model(), 'A17\Twill\Models\Behaviors\HasSlug')) {
            $fields[] = Str::make('slug');
        }

        if ($this->publishedAttribute) {
            $fields[] = Boolean::make('published');
        }

        if (classHasTrait($this->model(), 'A17\Twill\Models\Behaviors\HasPosition')) {
            $fields[] = Number::make('position')->sortable();
        }

        if (get_class($this) === BlockSchema::class) {
            $fields[] = BelongsToMany::make('blocks', 'children')->type('blocks')->serializeUsing(
                static fn($relation) => $relation->withMeta(function ($value) use ($relation) {
                    if ($value->relationLoaded('children')) {
                        $children = $value->children?->reduce(function ($carry, $model) {
                            $carry = $carry ?? [];
                            $carry[$model->child_key] = $carry[$model->child_key] ?? [];
                            $carry[$model->child_key][] = (string)$model->id;
                            return $carry;
                        });

                        return [
                            'children' => $children,
                        ];
                    }
                })
            );
        } elseif (classHasTrait($this->model(), 'A17\Twill\API\Models\Traits\HasChildBlocks')) {
            $fields[] = BelongsToMany::make('blocks', 'parentBlocks')->type('blocks')->serializeUsing(
                static fn($relation) => $relation->withMeta(function ($value) {
                    if ($value->relationLoaded('parentBlocks')) {
                        $editors = $value->parentBlocks?->reduce(function ($carry, $model) {
                            $carry = $carry ?? [];
                            $carry[$model->editor_name] = $carry[$model->editor_name] ?? [];
                            $carry[$model->editor_name][] = (string)$model->id;
                            return $carry;
                        });

                        return [
                            'editors' => $editors,
                        ];
                    }
                })
            );
        } elseif (classHasTrait($this->model(), 'A17\Twill\Models\Behaviors\HasBlocks')) {
            $fields[] = BelongsToMany::make('blocks');
        }

        if (classHasTrait($this->model(), 'A17\Twill\Models\Behaviors\HasMedias')) {
            $fields[] = BelongsToMany::make('media', 'mediables')->type('media')->serializeUsing(
                static fn($relation) => $relation->withMeta(function ($value) {
                    if ($value->relationLoaded('mediables')) {
                        $roles = $value->mediables?->reduce(function ($carry, $model){
                            $carry = $carry ?? [];
                            $carry[$model->role] = $carry[$model->role] ?? [];
                            $carry[$model->role][$model->crop] = $carry[$model->role][$model->crop] ?? [];
                            $carry[$model->role][$model->crop][] = (string) $model->id;
                            return $carry;
                        });

                        return [
                            'roles' => $roles,
                        ];
                    }
                })
            );
        }

        if (classHasTrait($this->model(), 'A17\Twill\Models\Behaviors\HasFiles')) {
            $fields[] = BelongsToMany::make('files', 'fileables')->type('files')->serializeUsing(static fn($relation) => $relation->withMeta(function ($value) {
                if ($value->relationLoaded('fileables')) {
                    $roles = $value->fileables?->reduce(function ($carry, $model) {
                        $carry = $carry ?? [];
                        $carry[$model->role] = $carry[$model->role] ?? [];
                        $carry[$model->role][] = (string)$model->id;
                        return $carry;
                    });

                    return ['roles' => $roles];
                }
            }));
        }

        if (classHasTrait($this->model(), 'A17\Twill\Models\Behaviors\HasRelated')) {
            $fields[] = BelongsToMany::make('related-items')->serializeUsing(
                static fn($relation) => $relation->withMeta(function ($value) {
                    if ($value->relationLoaded('relatedItems')) {
                        if (get_class($value) === Block::class) {
                            $source = collect($value->content['browsers'] ?? [])->map(
                                static fn($browser) => collect($browser)->map(
                                    static fn($id) => (string) $id
                                )
                            )->toArray();
                        }

                        $browsers = $value->relatedItems?->reduce(function ($carry, $model) use ($value, $source) {
                            $carry = $carry ?? [];
                            if (
                                get_class($value) !== Block::class
                                || in_array($model->related->id, $source[$model->browser_name] ?? [])
                            ) {
                                $carry[$model->browser_name] = $carry[$model->browser_name] ?? [];
                                $carry[$model->browser_name][] = (string) $model->id;
                            }
                            return $carry;
                        });

                        return [
                            'browsers' => $browsers ?? null,
                        ];
                    }
                })
            );
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
