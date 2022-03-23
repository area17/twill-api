<?php

namespace A17\Twill\API\JsonApi\V1\Medias;

use LaravelJsonApi\Eloquent\Fields\ID;
use LaravelJsonApi\Eloquent\Fields\Str;
use A17\Twill\API\JsonApi\Proxies\Media;
use LaravelJsonApi\Eloquent\ProxySchema;
use LaravelJsonApi\Eloquent\Fields\DateTime;
use LaravelJsonApi\Eloquent\Fields\ArrayHash;
use LaravelJsonApi\Eloquent\Filters\WhereIdIn;
use A17\Twill\Services\FileLibrary\FileService;
use LaravelJsonApi\Eloquent\Contracts\Paginator;
use LaravelJsonApi\Eloquent\Pagination\PagePagination;
use LaravelJsonApi\Eloquent\Fields\Relations\BelongsTo;

class MediaSchema extends ProxySchema
{

    /**
     * The model the schema corresponds to.
     *
     * @var string
     */
    public static string $model = Media::class;

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
            Str::make('uuid')->on('media'),
            Str::make('filename')->on('media'),
            Str::make('role'),
            Str::make('crop'),
            Str::make('ratio'),
            Str::make('lqip', 'lqip_data'),
            Str::make('src'),
            Str::make('originalSrc', 'uuid')->serializeUsing(
                static fn ($value) => FileService::getUrl($value)
            ),
            Str::make('width'),
            Str::make('height'),
            Str::make('alt'),
            Str::make('caption'),
            Str::make('video'),
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
