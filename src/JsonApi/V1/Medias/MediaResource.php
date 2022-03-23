<?php

namespace A17\Twill\API\JsonApi\V1\Medias;

use A17\Twill\Services\FileLibrary\FileService;
use LaravelJsonApi\Core\Resources\JsonApiResource;

class MediaResource extends JsonApiResource
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
            'uuid' => $this->media->uuid,
            'filename' => $this->media->filename,
            'role' => $this->role,
            'crop' => $this->crop,
            'ratio' => $this->ratio,
            'lqip' => $this->lqip_data,
            'src' => $this->image['src'],
            'originalSrc' => FileService::getUrl($this->media->uuid),
            'width' => $this->image['width'],
            'height' => $this->image['height'],
            'alt' => $this->image['alt'],
            'caption' => $this->image['caption'],
            'video' => $this->image['video'],
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
            'uuid' => $this->media->uuid,
        ];
    }
}
