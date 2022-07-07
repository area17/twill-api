<?php

namespace A17\Twill\API\JsonApi\V1\Files;

use A17\Twill\Services\FileLibrary\FileService;
use LaravelJsonApi\Core\Resources\JsonApiResource;

class FileResource extends JsonApiResource
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
            'uuid' => $this->file->uuid,
            'filename' => $this->file->filename,
            'role' => $this->role,
            'size' => $this->file->size,
            'originalSrc' => FileService::getUrl($this->file->uuid),
        ];
    }

    /**
     * Get meta for the resource.
     *
     * @return array
     */
    public function meta($request): iterable
    {
        return [
            'role' => $this->role,
            'uuid' => $this->file->uuid,
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
            'uuid' => $this->file->uuid,
        ];
    }
}
