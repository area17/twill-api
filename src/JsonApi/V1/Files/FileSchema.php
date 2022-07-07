<?php

namespace A17\Twill\API\JsonApi\V1\Files;

use LaravelJsonApi\Eloquent\Fields\ID;
use A17\Twill\API\JsonApi\Proxies\File;
use LaravelJsonApi\Eloquent\Fields\Str;
use LaravelJsonApi\Eloquent\ProxySchema;
use LaravelJsonApi\Eloquent\Fields\DateTime;
use LaravelJsonApi\Eloquent\Filters\WhereIdIn;
use A17\Twill\Services\FileLibrary\FileService;
use LaravelJsonApi\Eloquent\Contracts\Paginator;
use LaravelJsonApi\Eloquent\Pagination\PagePagination;

class FileSchema extends ProxySchema
{

    /**
     * The model the schema corresponds to.
     *
     * @var string
     */
    public static string $model = File::class;

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
            Str::make('uuid')->on('file'),
            Str::make('filename')->on('file'),
            Str::make('role'),
            Str::make('src'),
            Str::make('originalSrc', 'uuid')->serializeUsing(
                static fn ($value) => FileService::getUrl($value)
            ),
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
