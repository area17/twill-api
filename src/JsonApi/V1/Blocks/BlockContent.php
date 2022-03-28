<?php

namespace A17\Twill\API\JsonApi\V1\Blocks;

abstract class BlockContent
{
    protected $resource;

    public function __construct($resource)
    {
        $this->resource = $resource;
    }

    /**
     * Get the resource's content attributes.
     *
     * @return iterable
     */
    abstract public function content(): iterable;
}
