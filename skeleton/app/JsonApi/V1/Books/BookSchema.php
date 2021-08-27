<?php

namespace App\JsonApi\V1\Books;

use App\Models\Book;
use LaravelJsonApi\Eloquent\Schema;
use LaravelJsonApi\Eloquent\Fields\ID;
use LaravelJsonApi\Eloquent\Fields\Str;
use LaravelJsonApi\Eloquent\Fields\Number;
use LaravelJsonApi\Eloquent\Filters\Where;
use LaravelJsonApi\Eloquent\Fields\Boolean;
use LaravelJsonApi\Eloquent\Fields\DateTime;
use LaravelJsonApi\Eloquent\Fields\ArrayList;
use A17\Twill\Image\ImageFacade as TwillImage;
use LaravelJsonApi\Eloquent\Filters\WhereIdIn;
use LaravelJsonApi\Eloquent\Contracts\Paginator;
use LaravelJsonApi\Eloquent\Pagination\PagePagination;
use LaravelJsonApi\Eloquent\Fields\Relations\BelongsToMany;

class BookSchema extends Schema
{
    public const STATUS_PUBLISHED = 'published';
    public const STATUS_DRAFT = 'draft';

    /**
     * The model the schema corresponds to.
     *
     * @var string
     */
    public static string $model = Book::class;

    /**
     * Get the resource fields.
     *
     * @return array
     */
    public function fields(): array
    {
        return [
            ID::make(),
            DateTime::make('createdAt')->sortable()->readOnly(),
            DateTime::make('updatedAt')->sortable()->readOnly(),
            Str::make('slug'),
            Str::make('title'),
            Str::make('description'),
            Str::make('subtitle'),
            Str::make('summary'),
            Str::make('isbn'),
            DateTime::make('publication_date'),
            ArrayList::make('formats')->serializeUsing(
                static fn ($formats) => collect($formats)->map(fn ($value) => $value['id'])->all()
            ),
            ArrayList::make('topics')->serializeUsing(
                static fn ($formats) => collect($formats)->map(fn ($value) => $value['id'])->all()
            ),
            Boolean::make('forthcoming'),
            Number::make('available'),
            Number::make('position')->sortable(),
            Str::make('status', 'published')->serializeUsing(
                static fn ($value) => $value ? self::STATUS_PUBLISHED : self::STATUS_DRAFT
            ),
            ArrayList::make('cover')->extractUsing(
                self::twillImage('cover', ['crop' => 'default'])
            ),
            ArrayList::make('previewImages')->extractUsing(
                self::twillImage('preview', [
                    'crop' => 'default',
                    'sizes' => '75vw',
                ])
            ),
            BelongsToMany::make('blocks'),
            BelongsToMany::make('files'),
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

    public static function twillImage($role, $args = [], $preset = null)
    {
        return function ($model) use ($role, $args, $preset) {
            $medias = $model->imageObjects($role, $args['crop']);

            return $medias->map(function ($media) use ($model, $role, $args, $preset) {
                return TwillImage::source($model, $role, $args, $preset, $media);
            })->toArray();
        };
    }
}
