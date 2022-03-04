<?php

namespace A17\Twill\API\JsonApi\V1\Mediables;

use LaravelJsonApi\Core\Resources\JsonApiResource;

class MediableResource extends JsonApiResource
{

    /**
     * Get the resource's attributes.
     *
     * @param \Illuminate\Http\Request|null $request
     * @return iterable
     */
    public function attributes($request): iterable
    {
        return [
            'createdAt' => $this->created_at,
            'updatedAt' => $this->updated_at,
            'role' => $this->role,
            'crop' => $this->crop,
            'ratio' => $this->ratio,
            'lqip' => $this->lqip_data,
            'image' => $this->image,
        ];
    }

    /**
     * Get the resource's relationships.
     *
     * @param \Illuminate\Http\Request|null $request
     * @return iterable
     */
    public function relationships($request): iterable
    {
        return [
            $this->relation('media')->alwaysShowData(),
        ];
    }

    /**
     * Get the resource's meta.
     *
     * @param \Illuminate\Http\Request|null $request
     * @return iterable
     */
    public function meta($request): iterable
    {
        return [
            'uuid' => $this->media->uuid,
        ];
    }

    /**
     * Get meta for the resource's identifier.
     *
     * @return array
     */
    protected function identifierMeta(): array
    {
        return [
            'role' => $this->role,
            'crop' => $this->crop,
        ];
    }
}
