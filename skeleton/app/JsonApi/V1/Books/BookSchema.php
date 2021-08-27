<?php

namespace App\JsonApi\V1\Books;

use App\Models\Book;
use A17\Twill\Image\Facades\TwillImage;
use LaravelJsonApi\Eloquent\Fields\Str;
use LaravelJsonApi\Eloquent\Fields\Number;
use LaravelJsonApi\Eloquent\Fields\Boolean;
use LaravelJsonApi\Eloquent\Fields\DateTime;
use LaravelJsonApi\Eloquent\Fields\ArrayList;
use A17\Twill\API\JsonApi\V1\Models\ModelSchema;

class BookSchema extends ModelSchema
{
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
        $fields = parent::fields();

        return array_merge($fields, [
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
            ArrayList::make('cover')->extractUsing(
                static fn ($model) => TwillImage::sources($model, 'cover', [
                    'crop' => 'default'
                ])
            ),
            ArrayList::make('previewImages')->extractUsing(
                static fn ($model) => TwillImage::sources($model, 'preview', [
                    'crop' => 'default',
                    'sizes' => '75vw',
                ])
            ),
        ]);
    }

    /**
     * Get the resource filters.
     *
     * @return array
     */
    public function filters(): array
    {
        $filters = parent::filters();

        return array_merge($filters, [
            //
        ]);
    }
}
