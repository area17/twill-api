<?php

namespace A17\Twill\API\JsonApi\V1\Blocks;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use LaravelJsonApi\Core\Resources\JsonApiResource;

class BlockResource extends JsonApiResource
{

    /**
     * Get the resource's attributes.
     *
     * @param Request|null $request
     * @return iterable
     */
    public function attributes($request): iterable
    {
        return [
            'blockType' => $this->resource->type,
            'editorName' => $this->resource->editorName,
            'position' => $this->resource->position,
            'content' => $this->content(),
        ];
    }

    public function content()
    {
        $namespace = config('jsonapi.namespace');

        $version = Str::title(config('twill-api.version'));

        $blockContent = "BlockContent" . Str::title($this->resource->type);

        $classname = "App\\$namespace\\$version\\Blocks\\$blockContent";

        if (class_exists($classname)) {
            $content = (new $classname($this->resource))->content();
        }

        return $content ?? [];
    }
}
