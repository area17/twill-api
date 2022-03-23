<?php

namespace A17\Twill\API\JsonApi\Proxies;

use A17\Twill\API\Models\Mediable;
use LaravelJsonApi\Eloquent\Proxy;

class Media extends Proxy
{

    /**
     * Media constructor.
     *
     * @param Mediable|null $mediable
     */
    public function __construct(Mediable $mediable = null)
    {
        parent::__construct($mediable ?: new Mediable());
    }
}
